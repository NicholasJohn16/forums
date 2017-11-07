<?php 

class ComForumsControllerBehaviorLockable extends AnControllerBehaviorAbstract
{

	public function _actionLock($context)
    {
        $this->getItem()->locked = true;
        return $this->getItem();
    }

    public function _actionUnlock($context)
    {
        $this->getItem()->locked = false;
        return $this->getItem();
    }


}