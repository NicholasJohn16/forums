<?php 

class ComForumsDomainAuthorizerPost extends LibBaseDomainAuthorizerDefault 
{


	protected function _authorizeEdit($context) {

		if($this->_viewer->admin()) {
			return true;
		}

		if($this->_viewer->eql($this->_entity->author)) {
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

		$locked = $this->_entity->parent->locked || $this->_entity->parent->parent->locked;

		if(!$this->_viewer->guest() && !$locked) {
			return true;
		}
		
		return false;

	}

	protected function _authorizeVote($context) {

		if(!$this->_viewer->guest()) {
			return true;
		}

		return false;

	}

	protected function _authorizeEnable($context) {

		if($this->_viewer->admin() || $this->_viewer->eql($this->_entity->author)) {
			return true;
		}

		return false;
	}

	protected function _authorizeModerate($context) {

		if($this->_viewer->admin()) {
			return true;
		} 
		
		return false;
	}

}