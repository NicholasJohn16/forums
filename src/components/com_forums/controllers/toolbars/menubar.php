<?php

class ComForumsControllerToolbarMenubar extends ComBaseControllerToolbarMenubar
{

	public function onBeforeControllerGet(KEvent $event)
	{
		$actor = get_viewer();
		$controller = $this->getController();
		parent::onBeforeControllerGet($event);

		$this->addNavigation(
			'index', 
			translate('COM-FORUMS-INDEX'),
			'option=com_forums', 
			($controller->view == 'forums') || ($controller->view == 'category') || ($controller->view == 'forum')
		);

		$this->addNavigation(
			'recent-posts', 
			translate('COM-FORUMS-RECENT-POSTS'),
			'option=forums&view=posts',
			($controller->view == 'posts')
		);

		if(!$actor->guest()) {
			$this->addNavigation(
				'your-threads', 
				translate('COM-FORUMS-YOUR-THREADS'),
				array('option' => 'com_forums', 'view' => 'threads', 'oid' => $actor->uniqueAlias),
				($controller->view == 'threads' && $controller->oid == $actor->uniqueAlias)
			);

		}
	}

}