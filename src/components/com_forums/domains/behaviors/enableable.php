<?php

class ComForumsDomainBehaviorEnableable extends LibBaseDomainBehaviorEnableable {

	protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'attributes' => array(
                'enabled' => array(
                    'default' => true
                ),
              ),
        ));
        parent::_initialize($config);
    }

	protected function _beforeRepositoryFetch(KCommandContext $context)
	{

		$viewer = get_viewer();

		if(!$viewer->admin() ) {
	    	$context->query->where('IF(@col(enabled)=FALSE,0,1)');
	    }

	}


}