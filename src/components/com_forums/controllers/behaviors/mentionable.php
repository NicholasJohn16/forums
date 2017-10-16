<?php


class ComForumsControllerBehaviorMentionable extends ComPeopleControllerBehaviorMentionable
{
	
	public function notifyMentioned(KCommandContext $context)
    {
        $entity = $this->getItem();
        $subscribers = array();

        foreach ($this->_newly_mentioned as $username) {
            $person = $this->getService('repos://site/people.person')->find(array('username' => $username));

            if ($person && $person->authorize('mention')) {
                $subscribers[] = $person->id;
            }
        }

        if (count($subscribers) == 0) {
            return;
        }

        $data = array(
            'name' => 'actor_mention',
            'component' => 'com_fourms',
            'object' => $entity,
            'target' => $entity->author,
            'subscribers' => $subscribers,
        );
        
        $notification = $this->_mixer->createNotification($data);
        
    }


}