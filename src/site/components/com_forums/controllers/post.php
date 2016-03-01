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
                    'mentionable',
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

        public function _actionModerate($context)
        {
            $post = $this->getItem();

            if(get_viewer()->admin() && $post->parent->id !== $context->data->pid) {

                $originalParent = $post->parent;
                
                if($context->data->pid) //move to thread
                {
                    $post->parent->decrementPostCount();
                    $post->parent->resetLastReply();

                    $thread = $this->getService('repos://site/forums.thread')
                        ->getQuery()
                        ->where('id', '=', $context->data->pid)
                        ->fetch();

                    $post->set('parent', $thread)->save();
                    $thread->incrementPostCount();
                    $thread->resetLastReply();
                }
                else // create new thread
                {
                    $originalParent->decrementPostCount();

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

                    $thread->incrementPostCount();
                    $thread->setLastReply($post);
                    $originalParent->resetLastReply();
                }

                if(!$originalParent->posts->getTotal())  {
                    $originalParent->delete();
                }

            } else {
                $context->data->pid = $post->parent->id;
            }
            
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
