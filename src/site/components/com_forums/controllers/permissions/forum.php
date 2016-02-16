<?php

class ComForumsControllerPermissionForum extends LibBaseControllerPermissionDefault {

	public function canAdd() {
		
		if(get_viewer()->admin()) {
			return true;
		}
		
		return false;
	}

	public function canEdit() {

		if(get_viewer()->admin()) {
			return true;
		}

		return false;
	}

	public function canDelete() {
		
		if(get_viewer()->admin()) {
			return true;
		}
	
		return false;
	}

}