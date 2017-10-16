<?php

class ComForumsDomainBehaviorRepliable extends AnDomainBehaviorAbstract
{

	protected function _initialize(KConfig $config) {

		$config->append(array(
			'behaviors' => array(
				'dictionariable'
				),
			'attributes' => array(
					// 'locked' => array('column' => 'comment_status', 'default' => false, 'write' => 'protected'),
					// 'numOfReplies' => array('column' => 'comment_count', 'default' => 0, 'write' => 'private'),
					'lastReplyTime' => array('column' => 'last_comment_on', 'write' => 'private')
					// 'numOfThreads' => array('column' => 'meta')
				),
			'relationships' => array(
				'lastReply' => array('parent' => 'com:forums.domain.entity.post', 'write' => 'private', 'child_column' => 'last_comment_id'),
				'lastReplier' => array('parent' => 'com:people.domain.entity.person', 'child_column' => 'last_comment_by'),
				// 'replies' => array('child' => 'post', 'child_key' => 'parent', 'parent_delete' => 'ignore')
				),
			'posts' => array()
		));
	}

	public function setThreadCount($num) {
		$this->setValue('threadCount', $num);
	}

	public function getThreadCount() {
		return $this->getValue('threadCount') ? $this->getValue('threadCount') : 0;
	}

	public function incrementThreadCount($amount = 1) {
		$this->setValue('threadCount', $this->getValue('threadCount') + $amount);
	}

	public function decrementThreadCount($amount = 1) {
		$this->setValue('threadCount', $this->getValue('threadCount') - $amount);
	}

	public function setPostCount($num) {
		$this->setValue('postCount', $num);
	}

	public function getPostCount()
	{
		return $this->getValue('postCount');
	}

	public function incrementPostCount($amount = 1)
	{
		$this->setValue('postCount', $this->getValue('postCount') + $amount);
	}

	public function decrementPostCount($amount = 1)
	{
		$this->setValue('postCount', $this->getValue('postCount') - $amount);
	}

	public function getReplyCount()
	{
		if($this->getMixer()->getIdentifier()->name === 'thread') {
			$replyCount = $this->getValue('postCount') - 1;
    	} elseif($this->getMixer()->getIdentifier()->name === 'forum') {
    		$replyCount = $this->getValue('postCount') - $this->getValue('threadCount');
    	}

        return $replyCount;
  }

    public function setLastReply($post) {
    	
    	if($post) {
    		$this->set('lastReply', $post);
    		$this->set('lastReplier', $post->author);
    		$this->set('lastReplyTime', $post->creationTime);
    	} else {
    		$this->set('lastReply', null);
    		$this->set('lastReplier', null);
    		$this->set('lastReplyTime', null);
    	}
    }

    public function resetLastReply() {
    	$lastReply = null;

    	if($this->getMixer()->getIdentifier()->name === 'thread') {
    		$lastReply = $this->getMixer()->posts->reset()->order('creationTime', 'DESC')->fetch();
    	}

    	if($this->getMixer()->getIdentifier()->name === 'forum') {
    		if($this->threads->getTotal()) {
    			$thread = $this->getMixer()->threads->reset()->order('lastReplyTime', 'DESC')->fetch();
    			$lastReply = $thread->posts->order('creationTime', 'DESC')->fetch();
    		}
    	}

    	$this->setLastReply($lastReply);
    }

    public function getReplyOffset($id)
	{
		$this->getRepository()->getStore()->execute('set @i = 0');

		$query = clone $this->posts->getQuery();

		return $query->where('@col(id) < '.(int) $id)->order('created_on')->fetchValue('MAX(@i := @i + 1)');
	}

	public function recountStats() {

		if($this->getMixer()->getIdentifier()->name == 'forum') {
			$threadIds = $this->getMixer()->threads->reset()->select('id')->fetchValues('id');
			$threadCount = count($threadIds);
			$postCount = $this->getService('repos://site/forums.post')
							->getQuery()
							->where('parent_id', 'IN', $threadIds)
							->fetchValue('COUNT(id)');

			$this->setValue('threadCount', $threadCount);
			$this->setValue('postCount', $postCount);
		}

		if($this->getMixer()->getIdentifier()->name == 'thread') {
			$postCount = $this->getMixer()->posts->reset()->where('enabled','=','1')->getTotal();
			$this->setValue('postCount', $postCount);
		}
	}

}
