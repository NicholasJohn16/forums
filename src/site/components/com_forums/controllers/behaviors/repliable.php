<?php


class ComForumsControllerBehaviorRepliable extends KControllerBehaviorAbstract
{

    protected function _beforeControllerGet($context)
    {
        if($this->reply && !$context->request->isAjax()) {
            $offset = $this->getItem()->getReplyOffset($this->reply);
        	$start = (int) ($offset / $this->limit) * $this->limit;

        	$url = KRequest::url();
        	$query = $url->getQuery(true);

        	if($this->start != $start) {
        		$query = array_merge($query, array('start' => $start));
        	}

        	unset($query['reply']);
        	$url->setQuery($query);

        	$context->response->setRedirect($url.'#scroll='.$this->reply);
        }
    }

}
