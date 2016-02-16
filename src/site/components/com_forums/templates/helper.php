<?php

$autoloader = include JPATH_VENDOR.'/autoload.php';
$autoloader->add('Decoda', JPATH_LIBRARIES . '/decoda');

class ComForumsTemplateHelper extends KTemplateHelperAbstract {

    public $files = ["award",
                    "bell",
                    "book",
                    "burger",
                    "button",
                    "cake",
                    "calculator",
                    "calendar",
                    "camera",
                    "car",
                    "chat",
                    "chemistry-flask",
                    "clock",
                    "clown-mask",
                    "coffee-cup",
                    "coin",
                    "compass",
                    "couch",
                    "crown",
                    "cube",
                    "cup",
                    "diamond",
                    "eye",
                    "film-strip",
                    "fire",
                    "firework",
                    "flag",
                    "floppy-disc",
                    "flower-pot",
                    "folder",
                    "framed-pictures",
                    "gameboy",
                    "gift-box",
                    "globe",
                    "heart",
                    "home",
                    "hunting-bow",
                    "iMac",
                    "joypad",
                    "joystick",
                    "label",
                    "light-bulb",
                    "lighthouse",
                    "location-pin",
                    // "lock",
                    "macos-table",
                    "magnet",
                    "mail",
                    "map",
                    "megaphone",
                    "microphone",
                    "microwave",
                    "milkshake",
                    "mobile",
                    "mouse",
                    "music-note",
                    "mustache",
                    "paint-brush",
                    "painter-roll",
                    "paper-plane",
                    // "papers",
                    "pencil",
                    // "pie-chart",
                    "play-button",
                    "repair",
                    "ring",
                    "robot",
                    "rocket",
                    "scissors",
                    "search",
                    "settings",
                    "shield",
                    "shopping-bag",
                    "skull",
                    // "slider",
                    "speaker",
                    "stats",
                    "storm",
                    "suitcase",
                    "support",
                    "thermometre",
                    "thumb-down",
                    "thumb-up",
                    "thunder-bolt",
                    "toilet-paper",
                    "trash",
                    "ufo",
                    "user",
                    "vinyl",
                    "wallet",
                    "watermelon"];

    public function parentForum($category) {
        $html = $this->_template->getHelper('html');
        $parent = $category->parent;
        $options = array();
        
        if($category->id) {
            $forums = $this->getService('repos://site/forums.forum')                    
                    ->getQuery()
                    // ->where('id','!=',$forum->id)
                    ->clause()
                    ->where('parent_id','!=',$category->id)
                    ->where('parent_id','IS',NULL,'OR')
                    ->getParent()
                    ->fetchSet();
        } else {
            $forums = KService::get('repos://site/forums.forum')->fetchSet();
        }
        
        if (count($forums) === 0) {
            return JText::_('COM-FORUMS-NO-FORUMS');
        }

        $options[] = JText::_('COM-FORUMS-FORUM-SELECT-A-FORUM');

        foreach ($forums as $forum) {
            $options[$forum->id] = $forum->title;
        }

        return $html->select('pid', array('options' => $options, 'selected' => $parent ? $parent->id : null))->class('input-xlarge');
    }

    public function parentCategory($forum) {
        $html = $this->_template->getHelper('html');
        $parent = $forum->parent;
        $options = array();
        
        if($forum->id) {
            $categories = $this->getService('repos://site/forums.category')                    
                    ->getQuery()
                    // ->where('id','!=',$forum->id)
                    ->clause()
                    ->where('parent_id','!=',$forum->id)
                    ->where('parent_id','IS',NULL,'OR')
                    ->getParent()
                    ->fetchSet();
        } else {
            $categories = KService::get('repos://site/forums.category')->fetchSet();
        }
        
        if (count($categories) == 0) {
            return JText::_('COM-FORUMS-NO-CATEGORIES');
        }

        $options[] = JText::_('COM-FORUMS-CATEGORY-SELECT-A-CATEGORY');

        foreach ($categories as $category) {
            $options[$category->id] = $category->title;
        }

        return $html->select('pid', array('options' => $options, 'selected' => $parent ? $parent->id : null))->class('input-xlarge');   
    }

    public function forums($thread)
    {
        $html = $this->_template->getHelper('html');
        $options = array();

        $categories = $this->getService('repos://site/forums.category')
                    ->getQuery()
                    ->order('ordering')
                    ->fetchSet();

        foreach($categories as $category) {
            foreach($category->forums as $forum) {
                $options[$forum->id] = $forum->title;
            }
        }

        return $html->select('pid', array('options' => $options, 'selected' => $thread->pid));
    }

    public function threads($thread, $createNew = true)
    {

        $html = $this->_template->getHelper('html');
        $options = array();

        $entities = $this->getService('repos://site/forums.thread')
            ->getQuery()
            ->where('parent_id', '=', $thread->parent->id)
            ->order('last_comment_on','DESC')
            ->limit('20')
            ->fetchSet();

        $parameters = array();

        if($createNew) {
            $options[] = JText::_('COM-FORUMS-POST-CREATE-NEW-THREAD');
            $parameters['selected'] = $thread->id;
        } else {
            $options[] = JText::_('COM-FORUMS-THREAD-SELECT-THREAD');
        }

        $options[-1] = Jtext::_('COM-FORUMS-POST-SPECIFY-THREAD');

        foreach($entities as $entity) {
            $options[$entity->id] = $entity->title;
        }
        $parameters['options'] = $options;

        return $html->select('tid', $parameters)->class('input-xlarge');
    }

    public function getThreadIcons($currentIcon = false) {
        $threadIcons = array('papers');

        if($currentIcon) {
            $threadIcons[] = $currentIcon;
        }

        for($i = 0; $i < 7; $i++) {
            $threadIcons[] = $this->getThreadIcon($threadIcons);
        }

        return $threadIcons;


    }

    public function getThreadIcon($threadIcons) {
        $count = count($this->files) - 1;
        $threadIcon =  $this->files[rand(0, $count)];

        if(in_array($threadIcon, $threadIcons)) {
            return $this->getThreadIcon($threadIcons);
        } else {
            return $threadIcon;
        }
    }

    public function humanize($int) {

        if($int == 0) { return $int; }

        $abbreviations = array(12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => '');

        foreach($abbreviations as $exponent => $abbreviation) {
            if($int >= pow(10, $exponent)) {
                return round(floatval($int / pow(10, $exponent)),1).$abbreviation;
            }
        }
    }

    public function bbcode($text)
    {        
        $decoda = new Decoda\Decoda($text);
        $decoda->defaults();
        $decoda->setStrict(false);
        // $decoda->removeFilter('Video');
        $decoda->removeHook('Censor');
        //$decoda->removeFilter('Url');      
        
        $html = $decoda->parse();

        // $errors = $decoda->getErrors();
        // foreach($errors as $error) {
        //     $string = "";
        //     foreach($error as $key => $value) {
        //         $string = $key . ":" . $value . ", ";
        //     }
        //     error_log($string);
        // }
        // print_r($errors);

        $nesting = array(); 
        $closing = array();
        $scope = array();
        $errors = array();

        foreach ($decoda->getErrors() as $error) {
            switch ($error['type']) {
                case Decoda\Decoda::ERROR_NESTING:    $nesting[] = $error['tag']; break;
                case Decoda\Decoda::ERROR_CLOSING:    $closing[] = $error['tag']; break;
                case Decoda\Decoda::ERROR_SCOPE:    $scope[] = $error['child'] . ' in ' . $error['parent']; break;
            }
        }

        if (!empty($nesting)) {
            $errors[] = sprintf('The following tags have been nested in the wrong order: %s', implode(', ', $nesting));
        }

        if (!empty($closing)) {
            $errors[] = sprintf('The following tags have no closing tag: %s', implode(', ', $closing));
        }

        if (!empty($scope)) {
            $errors[] = sprintf('The following tags can not be placed within a specific tag: %s', implode(', ', $scope));
        }

        foreach($errors as $error) {
            $string = '<div class="alert alert-error">';
            $string .= $error;
            $string .= '</div>';
            echo $string;
        }
        
        return $html;
        // return $decoda->parse();
        // return $text;
    }

}