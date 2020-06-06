<?php 

class ComForumsControllerCategory extends ComBaseControllerService {
	
	public function __construct($config) {
		parent::__construct($config);

		$this->registerCallback(array('after.delete','after.add','after.edit'), array($this, 'redirect'));
	}

	protected function _initialize(KConfig $config) {

            $config->append(array(
                'behaviors' => array(
                    'parentable',
                    'privatable'
                )
             ));

            parent::_initialize($config);
        }

	public function _actionRead($context)
	{
		$toolbar = $this->getToolbar('category');
		$toolbar->addToolbarCommands();
		$this->getView()->set('toolbar', $toolbar);

		parent::_actionRead($context);
	}


	public function redirect(AnCommandContext $context)
    {
        
        $category = $this->getItem();

	    if ( $context->action == 'delete' ) 
	    {
            $route = route('option=com_forums');    
	        $this->getResponse()->setRedirect($route);
	    }	    
	    elseif ( $context->action == 'add' || $context->action == 'edit' ) 
	    {
	        $this->getResponse()->setRedirect(route($category->getURL()));
	    }
    }
}