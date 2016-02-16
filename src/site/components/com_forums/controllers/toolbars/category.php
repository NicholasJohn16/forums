<?php 

class ComForumsControllerToolbarCategory extends ComBaseControllerToolbarDefault {

	public function addToolbarCommands() {
		$entity = $this->getController()->getItem();

		if($entity->authorize('edit')) {
            $this->addCommand('edit');
        }
        
        if($entity->authorize('delete')) {
            $this->addCommand('delete');

            $this->getCommand('delete')
            	->dataRedirect(JRoute::_('index.php?option=com_forums'));
        }
	}

}