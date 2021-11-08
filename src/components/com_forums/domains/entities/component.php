<?php


class ComForumsDomainEntityComponent extends ComComponentsDomainEntityComponent {


    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'behaviors' => array(
                'assignable' => array(),
            ),
        ));

        parent::_initialize($config);
    }


	public function onSettingDisplay(AnEvent $event)
	{
		$viewer = $this->getService('com:people.viewer');
        $actor = $event->actor;
        $tabs = $event->tabs;

	    $tabs->insert('forum', array(
	        'label' => AnTranslator::_('COM-FORUMS-PROFILE-EDIT'),
	        'controller' => 'com://site/forums.controller.setting' 
	    ));
	}


}