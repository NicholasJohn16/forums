<?php

class ComForumsControllerSetting extends ComBaseControllerService {

    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'behaviors' => array(
                'ownable' => array(
                    'default' => $this->getService('com:people.viewer'),
                ),
            ),
        ));

        parent::_initialize($config);
    }

	protected function _actionRead(AnCommandContext $context)
	{
		$this->item = $this->getService('repos:forums.setting')->findOrAddNew(['person' => $this->actor]);
	}

    // protected function _actionEdit(AnCommandContext $context) {
    //     error_log(__CLASS__."::".__FUNCTION__);
    //     parent::_actionEdit($context);
    // }

    // protected function _actionPost(AnCommandContext $context)
    // {
    //     error_log(__CLASS__."::".__FUNCTION__);
    //     parent::_actionPost($context);
    // }

}