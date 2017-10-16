<?php 

class ComForumsTemplateHelperUi extends ComBaseTemplateHelperUi
{

	protected function _initialize(KConfig $config)
    {
        $config->append(array(
              'paths' => array(dirname(__FILE__).'/ui'),
        ));

        parent::_initialize($config);
    }

}