<?php

class ComForumsDomainEntitySetting extends AnDomainEntityDefault
{
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
            'attributes' => array(
            	'id',
                'signature'
            ),
            'identity_property' => 'id',
            'relationships' => array(
                'person' => array(
                	'parent' => 'com:people.domain.entity.person'
                )
            )
		));
	
		parent::_initialize($config);
	}
}