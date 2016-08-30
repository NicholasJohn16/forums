<?php

class ComForumsDomainEntityThread extends ComBaseDomainEntityNode {
    
    protected function _initialize(KConfig $config) {
        
        $config->append(array(
            'attributes' => array(
                'name' => array('required' => AnDomain::VALUE_NOT_EMPTY),
                'body'
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
        $this->parent->incrementThreadCount();
    }

    protected function _afterEntityDelete(KCommandContext $context) {
        $this->parent->decrementThreadCount();
    }

    public function isUnread()
    {
        $sevenDays = 86400 * 7;
        $diff = $this->creationTime->compare(new KDate()) * -1;
        
        return !$this->newNotificationIds->offsetExists(get_viewer()->id) && ($diff < $sevenDays);
    }

}