<?php 


class ComForumsControllerBehaviorVotable extends ComBaseControllerBehaviorVotable
{

	protected function _actionVote($context)
	{
		// 	$data = new KConfig();

		// $context->append(array(
		// 	'data' => array(
		// 		'target' => $this->getItem()->author
		// 	)
		// ));

		// parent::_actionVote($context);

		$context->response->status = AnHttpResponse::CREATED;

        $this->getItem()->voteup(get_viewer());

        $notification = $this->_mixer->createNotification(array(
            'name' => 'voteup',
            'object' => $this->getItem(),
            'target' => $this->getItem()->author,
            'component' => $this->getItem()->component,
        ));

        $context->response->content = $this->_mixer->execute('getvoters', $context);
	}

}