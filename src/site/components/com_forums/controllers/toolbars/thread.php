<?php

class ComForumsControllerToolbarThread extends ComBaseControllerToolbarDefault {

    public function onBeforeControllerGet(KEvent $event) {
        $this->getController()->toolbar = $this;
    }

    public function addToolbarCommands()
    {
        $entity = $this->getController()->getItem();

        if($entity 
            && $entity->authorize('add') 
            && !$entity->locked 
            && !$entity->parent->locked) {
            $this->addCommand('new');
        }

        if($entity && ($entity->locked || $entity->parent->locked)) {
          $this->addCommand('locked');
        }

        if($entity && ($entity->authorize('subscribe') || $entity->subscribed(get_viewer()))) {
            $this->addCommand('subscribe');
        }

        if($entity && $entity->authorize('pin')) {
            $this->addCommand('pin');
        }

        if($entity && $entity->authorize('lock')) {
            $this->addCommand('lock');
        }

        if($entity && $entity->authorize('delete')) {
            $this->addCommand('enable');

            $label = $entity->enabled ? 'COM-FORUMS-POST-DELETE' : 'COM-FORUMS-POST-RESTORE';
            $action = $entity->enabled ? 'disable' : 'enable';

            $this->getCommand('enable')
                ->label(JText::_($label))
                ->dataAction($action);
        }

        if($entity && $entity->authorize('delete') && !$entity->enabled) {
            $this->addCommand('delete');

            $this->getCommand('delete')
                ->dataRedirect(JRoute::_($entity->parent->getURL()));
        }

        if($entity && $entity->authorize('moderate')) {
            $this->addCommand('moderate');
        }


    }

    public function _commandNew($command) {
        $entity = $this->getController()->getItem();

        $command->append(array(
                'label'=>JText::_('COM-FORUMS-THREAD-REPLY')))
                ->href('option=com_forums&view=post&layout=add&pid='.$entity->id);
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
        $entity = $this->getController()->getItem();

        $label = $entity->locked ? 'COM-FORUMS-THREAD-LOCKED' : 'COM-FORUMS-FORUM-LOCKED';

        $command->append(array(
          'label' => JText::_($label)
        ))->class('btn btn-link')->href('#')->icon('lock');
    }

    public function _commandPin($command) {
        $entity = $this->getController()->getItem();
        $label = ($entity->pinned) ? JTEXT::_('COM-FORUMS-THREAD-UNSTICK') : JTEXT::_('COM-FORUMS-THREAD-STICKY');

        $command->append(array('label' => $label))
            ->href($entity->getURL().'&action='.($entity->pinned ? 'unpin' : 'pin'))
            ->setAttribute('data-trigger', 'PostLink');
    }

    public function _commandModerate($command) {
        $entity = $this->getController()->getItem();

        $command->append(array('label' => JText::_('COM-FORUMS-THREAD-MODERATE')))
            ->href(JRoute::_($entity->getURL().'&layout=moderate'));
    }

}
