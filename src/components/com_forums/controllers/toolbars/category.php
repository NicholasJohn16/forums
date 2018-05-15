<?php 

class ComForumsControllerToolbarCategory extends ComBaseControllerToolbarDefault {

	public function addToolbarCommands() {
		$entity = $this->getController()->getItem();

		if($entity && $entity->authorize('edit')) {
            $this->addCommand('edit');
        }
        
        if($entity && $entity->authorize('delete')) {
            $this->addCommand('delete');

            $this->getCommand('delete')
            	->dataRedirect(route('index.php?option=com_forums'));
        }
	}

}