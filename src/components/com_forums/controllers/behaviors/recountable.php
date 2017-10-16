<?php

class ComForumsControllerBehaviorRecountable extends KControllerBehaviorAbstract
{

	public function _actionRecount($context)
	{
		$forums = $this->getService('repos://site/forums.forum')->fetchSet();

		foreach($forums as $forum) {
			$forum->recountStats();
		}
	}

}