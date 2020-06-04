<?php

class ComForumsDomainEntityPost extends ComBaseDomainEntityNode {

    protected function _initialize(\KConfig $config)
    {

        $config->append(array(
            'attributes' => array(
                'name' => array('required' => AnDomain::VALUE_NOT_EMPTY),
                'body' => array('required' => AnDomain::VALUE_NOT_EMPTY)
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
        $thread = $this->parent;
        $forum = $thread->parent;

        $thread->incrementPostCount();
        $forum->incrementPostCount();
        $thread->setLastReply($this);
        $forum->setLastReply($this);
    }

    protected function _afterEntityUpdate($context)
    {
        $modifications = $this->getModifiedData();

        if($modifications->enabled && !$modifications->enabled->new) {
            $thread = $this->parent;
            $count = $thread->posts->reset()->where('enabled','=','1')->getTotal();


            if(!$count) {
                $thread->disable()->save();
            }
        }

        if($modifications->enabled && $modifications->enabled->new) {
          $this->parent->enable()->save();
        }
        
        if($modifications->enabled) {
            $this->parent->resetLastReply();
            $this->parent->recountStats();
        }
    }

    protected function _afterEntityDelete(KCommandContext $context)
    {
        $this->parent->parent->decrementPostCount();
        $this->parent->parent->resetLastReply();
        $this->parent->parent->save();

        if($this->parent->posts->getTotal()) {
            $this->parent->decrementPostCount();
            $this->parent->resetLastReply();
            $this->parent->save();
        } else {
            $this->parent->delete()->save();
        }

    }

    public function isUnread()
    {
        $sevenDays = 86400 * 7;
        $diff = $this->creationTime->compare(new AnDate()) * -1;

        return !$this->newNotificationIds->offsetExists(get_viewer()->id) && ($diff < $sevenDays);
    }

}
