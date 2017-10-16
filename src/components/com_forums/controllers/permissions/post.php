<?php

class ComForumsControllerPermissionPost extends LibBaseControllerPermissionDefault {

	public function canAdd() {
		$viewer = get_viewer();
		$entity = $this->_mixer;
		$locked = $entity->parent->locked || $entity->parent->parent->locked;

		if(!$viewer->guest() && !$locked) {
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
