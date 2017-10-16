<?php

class ComForumsDomainEntityForum extends ComBaseDomainEntityNode {

    protected function _initialize(KConfig $config) {

        $config->append(array(
            'attributes' => array(
                'name' => array('required' => AnDomain::VALUE_NOT_EMPTY),
                'body' => array('required' => AnDomain::VALUE_NOT_EMPTY)
            ),
            'relationships' => array(
                // 'forums' => array('through' => 'edge'),
                'threads'
                ),
            'behaviors' => array(
                'authorizer',
                'describable',
                'enableable',
                'orderable',
                'lockable',
                'modifiable' => array(
                    'modifiable_properties' => array('name','body')
                    ),
                'subscribable',
                'dictionariable',
                'parentable' => array('parent' => 'category'),
                'com://site/forums.domain.behavior.repliable',
                'privatable'
            )
        ));

        parent::_initialize($config);
    }

    public function getNewCount() {
        // $loginDate = get_viewer()->getLastLoginDate()->serialize();
        return $this->threads
                    ->getQuery()
                    // ->select('count(id)')
                    // ->where('last_comment_on', '>', $loginDate)
                    ->where('enabled', '=', 1)
                    ->clause()
                    ->where('FIND_IN_SET('.get_viewer()->id.',new_notification_ids)', '=', 0)
                    ->where('new_notification_ids','IS',NULL, 'OR')
                    ->getParent()
                    ->where('DATEDIFF(NOW(), created_on)', '<', '7')
                    ->fetchValue('count(id)');
    }
}