<?php 

class ComForumsDomainBehaviorPrivatable extends LibBaseDomainBehaviorPrivatable 
{

	protected function _beforeRepositoryFetch($context) 
	{

		if(KService::has('com:people.viewer') && is_person(get_viewer()) && get_viewer()->admin())
            return;

		$query = $context->query;
		$config = pick($query->privacy, new KConfig());

		$config->append(array(
			'viewer' => get_viewer()
			));

		$where = $this->buildCondition(get_viewer(), $config);

		$query->where($where);
	}

}