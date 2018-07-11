<?php 

class ComForumsControllerToolbarForum extends ComBaseControllerToolbarDefault {
    
    // public function onBeforeControllerGet(AnEvent $event) {
    //     $this->getController()->toolbar = $this;
    //     //$this->addCommand('add');

    // }

    // TODO instead of checking for an entity and all that
    // split commands into onBeforeControllerBrowse and onBeforeControllerGet
    // Remove calls to addToolbarCommands from controller
    
    public function addToolbarCommands() {
        $viewer = get_viewer();
        $entity = $this->getController()->getItem();

        if (!$entity && $viewer->admin()) {
            $this->addCommand('addCategory');
            $this->addCommand('addForum');
            $this->addCommand('recount');
        }

        if($entity && $entity->parent !== NULL && !$viewer->guest() && !$entity->locked) {
            $this->addCommand('new');
        }

        if($entity && $entity->locked) {
            $this->addCommand('locked');
        }
        
        if($entity && $entity->parent !== NULL 
            && ($entity->authorize('subscribe') || $entity->subscribed($viewer))) {
            $this->addCommand('subscribe');
        }

        if($entity && $entity->authorize('delete')) {
            $this->addCommand('lock');
            $this->addCommand('enable');

            $action = $entity->enabled ? 'disable' : 'enable';

            $this->getCommand('enable')
                // ->label(translate($label))
                ->dataAction($action);
        }
        
        if($entity && $entity->authorize('edit')) {
            $this->addCommand('edit');    
        }
        
        if($entity && $entity->authorize('delete')) {
            $this->addCommand('delete');

            $this->getCommand('delete')
                ->dataRedirect(route($entity->parent->getURL()));
        }
    }
   
    protected function _commandNew($command) 
    {
        $entity = $this->getController()->getItem();

        if($entity) {
            $command->append(array('label'=>translate('COM-FORUMS-THREAD-ADD')))
                ->setHref('option=com_forums&view=thread&layout=add&pid='.$entity->id);
        }
    }

    protected function _commandAddForum($command) 
    {
        $command->append(array('label' => translate('COM-FORUMS-FORUM-ADD')))
            ->href(route('index.php?option=com_forums&view=forum&layout=add'))
            ->class('btn btn-default');
    }

    protected function _commandAddCategory($command) 
    {
        $command->append(array('label' => translate('COM-FORUMS-CATEGORY-ADD')))
            ->href(route('index.php?option=com_forums&view=category&layout=add'))
            ->class('btn btn-default');
    }

    protected function _commandRecount($command)
    {
        $command->append(array(
                'label' => translate('COM-FORUMS-RECOUNT-STATS'),
                'attribs' => array('data-action' => 'recount')
                ))->class('btn btn-default')->href('#');
    }

    public function _commandLock($command) {
        $entity = $this->getController()->getItem();

        $label = $entity->locked ? 'COM-FORUMS-THREAD-UNLOCK' : 'COM-FORUMS-THREAD-LOCK';
        $action = $entity->locked ? 'unlock' : 'lock';

        $command->append(array(
                'label' => translate($label)
                ))->dataAction($action)
                ->href($entity->getURL());
    }

    public function _commandLocked($command) {
        $command->append(array(
          'label' => translate('COM-FORUMS-FORUM-LOCKED')
        ))->class('btn btn-link')->href('#')->icon('lock');
    }
    
}