<?php

    class ComForumsControllerPost extends ComBaseControllerService
    {

        public function __construct(KConfig $config)
        {
            parent::__construct($config);

            $this->registerCallback(array('after.add', 'after.edit'), array($this, 'redirect'));
            $this->registerCallback(array('after.add'), array($this, 'createStoryCallback'));
        }

        protected function _initialize(KConfig $config)
        {

            $config->append(array(
                'behaviors' => array(
                    'parentable',
                    'votable',
                    'com://site/forums.controller.behavior.enablable',
                    'com://site/stories.controller.behavior.publisher',
                    'com://site/notifications.controller.behavior.notifier',
                    'com://site/hashtags.controller.behavior.hashtagable',
                    'com://site/people.controller.behavior.mentionable',
                    'ownable' => array('default' => get_viewer())
                )
             ));

            parent::_initialize($config);
        }

        public function _actionRead($context)
        {
            $layout = $this->getRequest()->get('layout');
            $post = $this->getItem();

            if($this->parent) {
                $this->title = $this->parent->title;
            }

            if($this->qid) {

                $quote = $this->getService('repos://site/forums.post')
                    ->getQuery()
                    ->where('id', '=', $this->qid)
                    ->fetch();
                $this->body = '[quote="'.$quote->author->username.'" post='.$quote->id.']'.$quote->body."[/quote]\n\n";
            }

            if(!$layout) {
                $url = $post->parent->getURL();
                $this->getResponse()->setRedirect(JRoute::_($url).'?reply='.$post->id);
            }

            parent::_actionRead($context);
         }

        public function _actionEdit($context)
        {
            $post = $this->getItem();

            if($post->parent->id !== $context->data->pid && get_viewer()->admin()) {

                $originalParent = $post->parent;
                $behavior = $this->getService('repos://site/forums.thread')
                                ->getBehavior('repliable');

                if($context->data->pid)
                {
                    $behavior->decrementPostCount($post->parent);
                    $behavior->resetLastReply($post->parent);

                    $thread = $this->getService('repos://site/forums.thread')
                        ->getQuery()
                        ->where('id', '=', $context->data->pid)
                        ->fetch();

                    $post->set('parent', $thread)->save();
                    $behavior->incrementPostCount($thread);
                    $behavior->resetLastReply($thread);
                }
                else
                {
                    $behavior->decrementPostCount($originalParent);

                    $thread = $this->getService('repos://site/forums.thread')
                        ->getEntity(array(
                            'data' => array(
                                'name' => $post->name,
                                'author' => $post->author,
                                'parent' => $post->parent->parent
                            )
                        ));

                    $thread->save();
                    $post->set('parent', $thread)->save();

                    $behavior->incrementPostCount($thread);
                    $behavior->setLastReply($thread, $post);
                    $behavior->resetLastReply($originalParent);
                }

                if(!$originalParent->posts->getTotal())  {
                    $originalParent->delete();
                }

            } else {
                $context->data->pid = $post->parent->id;
            }

            parent::_actionEdit($context);
            $post->load(array('parent'));

            $this->getResponse()->setRedirect(JRoute::_($post->parent->getURL()));
        }

        public function _actionAdd($context)
        {
            $context->data->access = $context->data->parent->access;
            $context->data->author = get_viewer();
            $this->parent->resetRead();

            $post = parent::_actionAdd($context);

        }

        public function _actionDelete($context)
        {
            $post = $this->getItem();
            $thread = $post->parent;
            $url = $thread->getURL();

            $post->delete();

            if(!count($thread->posts)) {
                $url = $thread->parent->getURL();
                $thread->delete();
            }
        }

        public function createStoryCallback(KCommandContext $context)
        {
            $post = $this->getItem();


            if($context->result !== false ) {

                $story = $this->createStory(array(
                    'component' => 'com_forums',
                    'name' => 'post_add',
                    'owner' => $post->author,
                    'object' => $post,
                    'target' => $post->author
                ));

                $this->createNotification(array(
                    'name' => 'post_add',
                    'subject' => $post->author,
                    'target' => $post->author,
                    'object' => $post,
                    'subscribers' => $post->parent->subscriberIds->toArray()
                ));

                $context->data->story = $story;

                return $story;

            }

            return $context->result;
        }

        public function redirect()
        {
            $post = $this->getItem();
            $url = $post->parent->getURL() . '&reply=' . $post->id;
            $route = JRoute::_($url);

            $this->getResponse()->setRedirect($route);
        }

}
