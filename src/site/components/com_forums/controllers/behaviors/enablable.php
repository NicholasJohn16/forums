<?php 


class ComForumsControllerBehaviorEnablable extends ComBaseControllerBehaviorEnablable 
{

	protected function _actionDisable($context)
	{
		$entity = $this->getItem();
		$identifier = $entity->getIdentifier()->name;
		
		$entity->enabled = 0;

		if($identifier === 'post') {
			$viewer = get_viewer();

			 if($viewer->admin()) {
			 	$context->response->status = KHttpResponse::RESET_CONTENT;
	        	return $entity;
	        } else {
	        	$context->response->status = KHttpResponse::NO_CONTENT;
	        }
	    }

	    if($identifier === 'thread') {
	    	foreach($entity->posts as $post) {
	    		$post->enabled = 0;
	    	}

	    	return $entity;
	    }

	}

	protected function _actionEnable($context)
	{
		$entity = $this->getItem();

		if($entity->getIdentifier()->name === 'thread') {
			foreach($entity->posts as $post) {
				$post->enabled = 1;
			}
		}

		parent::_actionEnable($context);


	}

}