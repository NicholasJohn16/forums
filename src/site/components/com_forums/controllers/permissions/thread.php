<?php

class ComForumsControllerPermissionThread extends LibBaseControllerPermissionDefault {

	public function canAdd() {
		$viewer = get_viewer();

		if(!$viewer->guest() && !$this->_mixer->parent->locked) {
			return true;
		}

		return false;
	}

	public function canEdit() {
		$viewer = get_viewer();
		$entity = $this->getItem();
		
		if($viewer->admin() || $viewer->eql($entity->author)) {
			return true;
		} 

		return false;
	}

	public function canDelete() {
		$viewer = get_viewer();

		if($viewer->admin()) {
			return true;
		}
		
		return false;
	}

	public function canModerate() {
		$viewer = get_viewer();

		if($viewer->admin()) {
			return true;
		}
		
		return false;
	}

}