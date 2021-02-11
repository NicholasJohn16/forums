<?php 

class ComForumsDomainAuthorizerThread extends LibBaseDomainAuthorizerDefault 
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

		if(!$this->_viewer->guest()) {
			return true;
		}
		
		return false;
	}

	protected function _authorizeReply($context) {
		$locked = $this->_entity->locked || $this->_entity->parent->locked;

		if($this->_viewer->admin()) {
			return true;
		}

		if(!$this->_viewer->guest() && !$locked) {
			return true;
		}
		
		return false;
	}

	protected function _authorizeLock($context) {

		if($this->_viewer->admin()) {
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

	protected function _authorizePin($context)
	{
		if($this->_viewer->admin()) {
			return true;
		}

		return false;
	}

}