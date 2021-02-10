<?php

class ComForumsControllerThread extends ComBaseControllerService
{

    // public function __construct(KConfig $config) {
    //     $this->registerCallback('before.edit', 'removeTags');
    //
    //     parent::__construct($config);
    // }

    protected function _initialize(\KConfig $config)
    {

        $config->append(array(
            'behaviors' => array(
                'parentable',
                'subscribable',
                'pinnable',
                'enablable',
                'mentionable',
                'lockable',
                'com://site/stories.controller.behavior.publisher',
                'com://site/notifications.controller.behavior.notifier',
                'com://site/forums.controller.behavior.hashtagable',
                'com://site/forums.controller.behavior.repliable',
                'ownable' => array('default' => get_viewer()) //needed for /threads route
            )
        ));

        parent::_initialize($config);
    }

    public function _actionBrowse($context)
    {
        $owner = $context->data->owner;
        $threads = parent::_actionBrowse($context);
        $threads->where('created_by', '=', $owner->id);

        return $threads;
    }

    public function _actionRead($context)
    {
        $repos = $this->getService('repos://site/forums.thread');

        if($thread = $this->getItem()) {
            $limit = $this->getRequest()->get('limit');
            $start = $this->getRequest()->get('start');

            $thread->posts->getQuery()->order('created_on')->limit($limit, $start);
            $thread->hit();

            $this->registerCallback('after.get', array($thread, 'markRead'));
            $this->registerCallback('after.get', array($thread->posts, 'markRead'));
        }

        $toolbar = $this->getToolbar('thread');
        $toolbar->addToolbarCommands();
        $this->getView()->set('toolbar', $toolbar);

        parent::_actionRead($context);
    }

    public function _actionAdd($context)
    {
        $viewer = get_viewer();

        $thread = $this->getService('repos://site/forums.thread')
                ->getEntity(array(
                    'data' => array(
                        'name' => $context->data->name,
                        'author' => $viewer,
                        // 'owner' => $viewer,
                        'parent' => $context->data->parent,
                        'access' => $context->data->parent->access
                    )
                ));

        $thread->setValue('thread_icon', $context->data->thread_icon);

        $thread->save();

        $post = $this->getService('repos://site/forums.post')
                ->getEntity(array(
                    'data' => array(
                        'name' => $context->data->name,
                        'body' => $context->data->body,
                        'author' => $viewer,
                        // 'owner' => $viewer,
                        'parent' => $thread,
                        'access' => $context->data->parent->access
                    )
                ));

        $post->save();


        $this->setItem($post);

        $this->createStory(array(
            'name' => 'thread_add',
            'owner' => $post->author,
            'object' => $post,
            'target' => $post->author
        ));

        $this->createNotification(array(
            'name' => 'thread_add',
            'subject' => $thread->author,
            'target' => $thread->author,
            'object' => $post, // maybe this should be $post?
            'subscribers' => $context->data->parent->subscriberIds->toArray()
        ));

        dispatch_plugin('forums.onAfterSaveThread', array('data' => $post));
        
        $this->getResponse()->setRedirect(route($thread->getURL()));
    }

    public function _actionModerate($context)
    {
        if(get_viewer()->admin())
        {
            $thread = $this->getItem();

            // change parent forum
            if($context->data->pid && $thread->parent->id !== $context->data->pid)
            {
                $oldParent = $thread->parent;

                $newParent = $this->getService('repos://site/forums.forum')
                            ->getQuery()
                            ->where('id', '=', $context->data->pid)
                            ->fetch();
                $thread->set('parent', $newParent);
                $thread->set('access', $newParent->access);
                $thread->save();

                foreach($thread->posts as $post) {
                    $post->set('access', $newParent->access);
                }

                $postCount = count($thread->posts);

                $oldParent->decrementThreadCount();
                $oldParent->decrementPostCount($postCount);
                $oldParent->resetLastReply();

                $newParent->incrementThreadCount();
                $newParent->incrementPostCount($postCount);
                $newParent->resetLastReply();
            }

            // update name
            if($context->data->update_replies) {
                foreach($thread->posts as $post) {
                    $post->title = $context->data->title;
                    $post->save();
                }
            }

            // merge threads
            if($context->data->target_id) {

                $postCount = count($thread->posts);
                $mergeThread = $this->getService('repos://site/forums.thread')
                                    ->getQuery()
                                    ->where('id','=', $context->data->target_id)
                                    ->fetch();

                foreach($thread->posts as $post) {
                    // Extract post from current association
                    // so its not deleted when thread is deleted
                    // this basically just sets the parent_id to
                    // null so you have to od this first or any
                    // changes get overwritten
                    $thread->posts->extract($post);
                    // set the merge thread as the new parent
                    $post->set('parent', $mergeThread);

                    if($post->access != $mergeThread->access) {
                        $post->set('access', $mergeThread->access);
                    }

                    // and then save it
                    $post->save();
                }

                $thread->posts->save();

                $mergeThread->incrementPostCount($postCount);
                $mergeThread->resetLastReply();

                if($thread->parent->id !== $mergeThread->parent->id) {
                    $thread->parent->decrementThreadCount();
                    $thread->parent->decrementPostCount($postCount);
                    $mergeThread->parent->incrementThreadCount();
                    $mergeThread->parent->incrementPostCount($postCount);
                }

                $thread->parent->resetLastReply();
                $mergeThread->parent->resetLastReply();

                $this->getService('repos://site/forums.thread')->destroy($thread->id);

                $thread = $mergeThread;
            }
        }

        // parent::_actionEdit($context);

        $this->getResponse()->setRedirect(route($thread->getURL()));
    }

    public function _actionDelete($context)
    {
        $thread = $this->getItem();
        $url = $thread->parent->getURL();

        $thread->delete();
        $this->getResponse()->setRedirect(route('index.php?' . $url));
    }

}