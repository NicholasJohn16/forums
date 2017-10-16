<?php

class ComForumsControllerToolbarPost extends ComBaseControllerToolbarDefault {

    public function addToolbarCommands() {
        $entity = $this->getController()->getItem();
        $locked = $entity->parent->locked || $entity->parent->parent->locked;

        if($entity->authorize('vote')) {
            $this->addCommand('vote');

            $this->getCommand('vote')
                ->class('btn btn-mini')
                ->icon('thumbs-up');

            $this->getCommand('unvote')
                ->class('btn btn-mini')
                ->icon('thumbs-down');
        }

        if($entity->authorize('edit') && !$locked) {
            $this->addCommand('edit');

            $this->getCommand('edit')
                ->class('btn btn-mini')
                ->icon('edit');
        }

        if($entity->authorize('add') && !$locked) {
            $this->addCommand('reply');
            $this->addCommand('quote');

            $this->addCommand('quickreply');
            $this->addCommand('quickquote');
        }

        if($entity->authorize('enable') && !$locked) {
            $this->addCommand('enable');

            $label = $entity->enabled ? 'COM-FORUMS-POST-DELETE' : 'COM-FORUMS-POST-RESTORE';
            $action = $entity->enabled ? 'disable' : 'enable';
            $icon = $entity->enabled ? 'remove' : 'ok';

            $this->getCommand('enable')
                ->label(translate($label))
                ->dataAction($action)
                ->class('btn btn-mini')
                ->icon($icon);
        }
    }

    public function addAdministrationCommands() {
        $entity = $this->getController()->getItem();

        if($entity->authorize('delete') && !$entity->enabled) {
            $this->addCommand('delete');

            $this->getCommand('delete')
                ->label(translate('COM-FORUMS-POST-PERMANENTLY-DELETE'))
                ->dataRedirect(route($entity->parent->getURL()))
                ->class('btn btn-mini')
                ->icon('remove');
        }

        if($entity->authorize('moderate')) {
            $this->addCommand('moderate');
        }
    }

    public function _commandReply($command) {
        $entity = $this->getController()->getItem();

        $command->append(array(
            'label' => translate('COM-FORUMS-POST-REPLY')))
            ->href('option=com_forums&view=post&layout=add&pid='.$entity->parent->id)
            ->class('btn btn-mini btn-default')
            ->icon('post-reply');
    }

    public function _commandQuickreply($command)
    {
        $entity = $this->getController()->getItem();

        $command->append(array(
            // 'label' => translate('COM-FORUMS-POST-QUICKREPLY'))
            ))->href('#')
            ->title(translate('COM-FORUMS-POST-QUICKREPLY'))
            ->dataAction('quickreply')
            ->dataTarget('forum-quickreply-'.$entity->id)
            ->class('btn btn-default btn-mini')
            ->icon('post-quickreply');
    }

    public function _commandQuickquote($command)
    {
        $entity = $this->getController()->getItem();

        if($entity->author) {
            $openTag = '[quote="'.$entity->author->username.'"';
        } else {
            $openTag = '[quote';
        }

        $quote =  $openTag . ' post='.$entity->id.']'.$entity->body.'[/quote]';

        $command->append(array(
            // 'label' => translate('COM-FORUMS-POST-QUICKQUOTE'))
            ))->href('#')
            ->title(translate('COM-FORUMS-POST-QUICKQUOTE'))
            ->dataAction('quickquote')
            ->dataTarget('forum-quickreply-'.$entity->id)
            ->dataQuote(htmlentities($quote) . '&#13;&#10;&#13;&#10;')
            ->class('btn btn-default btn-mini')
            ->icon('post-quickquote');
    }

    public function _commandQuote($command)
    {
        $entity = $this->getController()->getItem();

        $command->append(array(
            'label' => translate('COM-FORUMS-POST-QUOTE')))
            ->href('option=com_forums&view=post&layout=add&pid='.$entity->parent->id.'&qid='.$entity->id)
            ->class('btn btn-mini btn-default')
            ->icon('post-quote');
    }

    public function _commandModerate($command) {
        $entity = $this->getController()->getItem();

        $command->append(array(
            'label' => translate('COM-FORUMS-POST-MODERATE')))
            ->href(route($entity->getURL().'&layout=moderate'))
            ->class('btn btn-default btn-mini')
            ->icon('wrench');
    }

}
