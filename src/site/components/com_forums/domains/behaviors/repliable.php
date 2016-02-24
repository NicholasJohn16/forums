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

	public function setThreadCount($entity, $num) {
		$entity->setValue('threadCount', $num);
	}

	public function getThreadCount($entity) {
		return $entity->getValue('threadCount');
	}

	public function incrementThreadCount($entity, $amount = 1) {
		$entity->setValue('threadCount', $entity->getValue('threadCount') + $amount);
	}

	public function decrementThreadCount($entity, $amount = 1) {
		$entity->setValue('threadCount', $entity->getValue('threadCount') - $amount);
	}

	public function setPostCount($entity, $num) {
		$entity->setValue('postCount', $num);
	}

	public function getPostCount($entity)
	{
		return $entity->getValue('postCount');
	}

	public function incrementPostCount($entity, $amount = 1)
	{
		$entity->setValue('postCount', $entity->getValue('postCount') + $amount);
	}

	public function decrementPostCount($entity, $amount = 1)
	{
		$entity->setValue('postCount', $entity->getValue('postCount') - $amount);
	}

	public function getReplyCount($entity)
	{
		if($entity->getIdentifier()->name === 'thread') {
			$replyCount = $entity->getValue('postCount') - 1;
    	} elseif($entity->getIdentifier()->name === 'forum') {
    		$replyCount = $entity->getValue('postCount') - $entity->getValue('threadCount');
    	}

        return $replyCount;
  }

    public function setLastReply($entity, $post) {
    	
    	if($post) {
    		$entity->set('lastReply', $post);
    		$entity->set('lastReplier', $post->author);
    		$entity->set('lastReplyTime', $post->creationTime);
    	} else {
    		$entity->set('lastReply', null);
    		$entity->set('lastReplier', null);
    		$entity->set('lastReplyTime', null);
    	}
    }

    public function resetLastReply($entity) {

    	if($entity->getIdentifier()->name === 'thread') {
    		$lastReply = $entity->posts->reset()->order('creationTime', 'DESC')->fetch();
    	}

    	if($entity->getIdentifier()->name === 'forum') {
    		$thread = $entity->threads->reset()->order('lastReplyTime', 'DESC')->fetch();
    		$lastReply = $thread->posts->order('creationTime', 'DESC')->fetch();
    	}

    	$this->setLastReply($entity, $lastReply);
    }

    public function getReplyOffset($id)
	{
		$this->getRepository()->getStore()->execute('set @i = 0');

		$query = clone $this->posts->getQuery();

		return $query->where('@col(id) < '.(int) $id)->order('created_on')->fetchValue('MAX(@i := @i + 1)');
	}

	public function recountStatsFor($entity) {

		if($entity->getIdentifier()->name == 'forum') {
			$threadIds = $entity->threads->reset()->select('id')->fetchValues('id');
			$threadCount = count($threadIds);
			$postCount = $this->getService('repos://site/forums.post')->getQuery()->where('parent_id', 'IN', $threadIds)->fetchValue('COUNT(id)');

			$entity->setValue('threadCount', $threadCount);
			$entity->setValue('postCount', $postCount);
		}

		if($entity->getIdentifier()->name == 'thread') {
			$postCount = $entity->posts->reset()->where('enabled','=','1')->getTotal();
			$entity->setValue('postCount', $postCount);
		}
	}

}
