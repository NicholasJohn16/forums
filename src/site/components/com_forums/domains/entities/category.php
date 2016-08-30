<?php 

class ComForumsDomainEntityCategory extends ComBaseDomainEntityNode {

	protected function _initialize(KConfig $config) {

		$config->append(array(
			'attributes' => array(
				'name' => array('required' => AnDomain::VALUE_NOT_EMPTY)
			),
			'relationships' => array('forums'),
			'behaviors' => array(
				'authorizer',
				'describable',
				'orderable',
				'parentable' => array('parent' => 'forum'),
				'privatable'
				)
			));

		parent::_initialize($config);

	}

}