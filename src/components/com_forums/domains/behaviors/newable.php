<?php

class ComForumsDomainBehaviorNewable extends AnDomainBehaviorAbstract
{

	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'attributes' => array(
				'newNotificationIds' => array('type' => 'set', 'default' => 'set', 'write' => 'private')
			)
		));

		parent::_initialize($config);
	}

	public function markRead()
	{
		$viewer = get_viewer();
		
		if(!$this->newNotificationIds->offsetExists($viewer->id)) {
			$ids = clone $this->newNotificationIds;
			$ids[] = $viewer->id;
			$this->set('newNotificationIds',  $ids)->save();
		}
	}

	public function resetRead() 
	{
		$this->set('newNotificationIds', AnDomainAttribute::getInstance('set'))->save();
	}
}