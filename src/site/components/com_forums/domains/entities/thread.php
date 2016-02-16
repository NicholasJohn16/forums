<?php

class ComForumsDomainEntityThread extends ComBaseDomainEntityNode {
    
    protected function _initialize(KConfig $config) {
        
        $config->append(array(
            'attributes' => array(
                'name' => array('required' => AnDomain::VALUE_NOT_EMPTY),
                'oldid' => array('column' => 'filesize', 'type' => 'integer')
            ),
            'behaviors' => array(
                'authorizer',
                'describable',
                'dictionariable',
                'enableable',
                'com://site/forums.domain.behavior.hittable',
                'com://site/forums.domain.behavior.newable',
                'lockable',
                'modifiable',
                'parentable' => array('parent' => 'forum'),
                'privatable',
                'pinnable',
                'com://site/forums.domain.behavior.repliable',
                'subscribable',
            ),
            'relationships' => array(
                'posts' //=> array('limit' => 10)
            )
        ));
        
        parent::_initialize($config);
    }

    public function getReplyCount() {
        return $this->getValue('postCount') - 1;
    }
    
    protected function _afterEntityInsert(KCommandContext $context) {
        // $this->getService('repos:forums.thread')->getBehavior('repliable')->resetStats($this->parent);
        // $this->getService('repos:forums.thread')->getBehavior('repliable')->resetStats($this->parent->parent);
        // $this->parent->getRepository()->getBehavior('repliable')->resetStats(array($this->parent));
        $behavior = $this->getService('repos:forums.thread')->getBehavior('repliable');
        $behavior->incrementThreadCount($this->parent);
    }

    protected function _afterEntityDelete(KCommandContext $context) {
        // $this->parent->getRepository()->getBehavior('repliable')->resetStats($this->parent->parent);
        $behavior = $this->getService('repos:forums.thread')->getBehavior('repliable');
        $behavior->decrementThreadCount($this->parent);
    }

    public function isUnread()
    {
        $sevenDays = 86400 * 7;
        $diff = $this->creationTime->compare(new KDate()) * -1;
        
        return !$this->newNotificationIds->offsetExists(get_viewer()->id) && ($diff < $sevenDays);
    }

}