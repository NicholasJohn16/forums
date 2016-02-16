<?php

class ComForumsDomainEntityPost extends ComBaseDomainEntityNode {

    protected function _initialize(\KConfig $config)
    {

        $config->append(array(
            'attributes' => array(
                'name' => array('required' => AnDomain::VALUE_NOT_EMPTY),
                'body' => array('required' => AnDomain::VALUE_NOT_EMPTY),
                'oldid' => array('column' => 'filesize', 'type' => 'integer')
            ),
            'behaviors' => array(
                'parentable' => array(
                    'parent' => 'thread',
                    'parent_delete'=>'ignore'
                ),
                'modifiable' => array(
                    'modifiable_properties' => array('name','body')
                ),
                'describable',
                'votable',
                'authorizer',
                'enableable',
                'com://site/hashtags.domain.behavior.hashtagable',
                'com://site/people.domain.behavior.mentionable',
                'privatable',
                'com://site/forums.domain.behavior.newable'
            )
        ));

        parent::_initialize($config);
    }

    public function getThreadURL()
    {
        return $this->parent->getURL().'&reply='.$this->id;
    }

    protected function _afterEntityInsert(KCommandContext $context)
    {
        $behavior = $this->getService('repos://site/forums.thread')->getBehavior('repliable');
        $behavior->incrementPostCount($this->parent);
        $behavior->incrementPostCount($this->parent->parent);
        $behavior->setLastReply($this->parent, $this);
        $behavior->setLastReply($this->parent->parent, $this);
    }

    protected function _afterEntityDelete(KCommandContext $context)
    {
        $behavior = $this->getService('repos://site/forums.thread')->getBehavior('repliable');
        $behavior->decrementPostCount($this->parent);
        $behavior->decrementPostCount($this->parent->parent);
        $behavior->resetLastReply($this->parent);
        $behavior->resetLastReply($this->parent->parent);
    }

    public function isUnread()
    {
        $sevenDays = 86400 * 7;
        $diff = $this->creationTime->compare(new KDate()) * -1;
        
        return !$this->newNotificationIds->offsetExists(get_viewer()->id) && ($diff < $sevenDays);
    }

}
