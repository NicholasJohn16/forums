<?php 

class ComForumsDomainAuthorizerForum extends LibBaseDomainAuthorizerDefault {

	protected function _authorizeEdit($context) {

		if($this->_viewer->admin()) {
			return true;
		}
	
		return false;
	}

	protected function _authorizeDelete($context) {

		if($this->_viewer->admin()) {
			return true;
		} 
		
		return false;
	}

	protected function _authorizeAdd($context) {

		if($this->_viewer->admin()) {
			return true;
		}
		
		return false;

	}


}