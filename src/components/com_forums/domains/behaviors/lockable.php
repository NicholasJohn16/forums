<?php 

class ComForumsDomainBehaviorLockable extends AnDomainBehaviorAbstract
{

	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'attributes' => array(
				'locked' => array('column' => 'comment_status', 'default' => false, 'write' => 'protected'),
			)
		));
	}

}