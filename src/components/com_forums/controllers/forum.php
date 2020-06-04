<?php

class ComForumsControllerForum extends ComBaseControllerService {
    
    public function __construct(KConfig $config) {
        
        parent::__construct($config);

        $this->registerCallback(array('after.delete','after.add','after.edit'), array($this, 'redirect'));
    }
    
    protected function _initialize(\KConfig $config) {
        
        $config->append(array(
            'request' => array(
                'order' => 'ordering'
            ),
            'behaviors' => array(
                'parentable',
                'subscribable',
                'privatable',
                'lockable',
                'com://site/forums.controller.behavior.recountable',
                'enablable'
            )
        ));
        
        parent::_initialize($config);
    }

    public function _actionBrowse($context)
    {
    //     $session = Kservice::get('com://site/people.controller.session');
    //     $viewer = get_viewer();

    //     $session = JFactory::getSession();

        $this->categories = KService::get('repos://site/forums.category')->getQuery()->order('ordering')->fetchSet();

        parent::_actionBrowse($context);
    }
    
    public function _actionRead($context) {
        $limit = ($context->request->limit) ? $context->request->limit : 20;
        $start = ($context->request->start) ? $context->request->start : 0;
        
        // $this->forums = $this->getService('repos://site/forums.forum')
        //     ->getQuery()
        //     ->where('parent_id','=',$context->request->id)
        //     ->order('ordering','ASC')
        //     ->fetchSet();

        $toolbar = $this->getToolbar('forum');
        $toolbar->addToolbarCommands();
        $this->getView()->set('toolbar', $toolbar);
        
        $this->threads = $this->getService('repos://site/forums.thread')
            ->getQuery()
            ->where('parent_id','=',$context->request->id)
            ->order('pinned', 'DESC')
            ->order('last_comment_on','DESC')
            ->limit($limit,$start)
            ->fetchSet();
    }
    
    public function _actionEdit($context) {
        parent::_actionEdit($context);
    }

    public function redirect(KCommandContext $context)
    {
        
        $forum = $this->getItem();

	    if ( $context->action == 'delete' ) 
	    {
            $route = route('index.php?option=com_forums');
	        $this->getResponse()->setRedirect($route);
	    }	    
	    elseif ( $context->action == 'add' || $context->action == 'edit' ) 
	    {
	        $this->getResponse()->setRedirect(route($forum->getURL()));
	    }
    }
    
}