<?php 

class ComForumsControllerToolbarForum extends ComBaseControllerToolbarDefault {
    
    // public function onBeforeControllerGet(KEvent $event) {
    //     $this->getController()->toolbar = $this;
    //     //$this->addCommand('add');

    // }
    
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
                // ->label(JText::_($label))
                ->dataAction($action);
        }
        
        if($entity && $entity->authorize('edit')) {
            $this->addCommand('edit');    
        }
        
        if($entity && $entity->authorize('delete')) {
            $this->addCommand('delete');

            $this->getCommand('delete')
                ->dataRedirect(JRoute::_($entity->parent->getURL()));
        }
    }
   
    protected function _commandNew($command) 
    {
        $entity = $this->getController()->getItem();

        if($entity) {
            $command->append(array('label'=>JText::_('COM-FORUMS-THREAD-ADD')))
                ->setHref('option=com_forums&view=thread&layout=add&pid='.$entity->id);
        }
    }

    protected function _commandAddForum($command) 
    {
        $command->append(array('label' => JText::_('COM-FORUMS-FORUM-ADD')))
            ->href(JRoute::_('index.php?option=com_forums&view=forum&layout=add'))
            ->class('btn btn-default');
    }

    protected function _commandAddCategory($command) 
    {
        $command->append(array('label' => JText::_('COM-FORUMS-CATEGORY-ADD')))
            ->href(JRoute::_('index.php?option=com_forums&view=category&layout=add'))
            ->class('btn btn-default');
    }

    protected function _commandRecount($command)
    {
        $command->append(array(
                'label' => JText::_('COM-FORUMS-RECOUNT-STATS'),
                'attribs' => array('data-action' => 'recount')
                ))->class('btn btn-default')->href('#');
    }

    public function _commandLock($command) {
        $entity = $this->getController()->getItem();

        $label = $entity->locked ? 'COM-FORUMS-THREAD-UNLOCK' : 'COM-FORUMS-THREAD-LOCK';
        $action = $entity->locked ? 'unlock' : 'lock';

        $command->append(array(
                'label' => JText::_($label)
                ))->dataAction($action)
                ->href($entity->getURL());
    }

    public function _commandLocked($command) {
        $command->append(array(
          'label' => JText::_('COM-FORUMS-FORUM-LOCKED')
        ))->class('btn btn-link')->href('#')->icon('lock');
    }
    
}