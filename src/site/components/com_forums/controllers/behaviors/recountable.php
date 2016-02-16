<?php

class ComForumsControllerBehaviorRecountable extends KControllerBehaviorAbstract
{

	public function _actionRecount($context)
	{
		$forums = $this->getService('repos://site/forums.forum')->fetchSet();

		$repliable = $this->getService('repos://site/forums.forum')
						->getBehavior('repliable');

		foreach($forums as $forum) {
			$repliable->recountStatsFor($forum);
		}
	}

}