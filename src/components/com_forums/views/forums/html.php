<?php

class ComForumsViewForumsHtml extends ComBaseViewHtml {
    
    // protected function _layoutDefault() {
        
    //     $this->categories = KService::get('repos://site/forums.category')->fetchSet();

    // }
    
    protected function findChildren($parent,$forums) {
        $parent->set('children',array());
        
        foreach($forums as $forum) {
            if($forum->parent_id == $parent->id) {
                $children = $parent->get('children');
                $children[] = $forum;
                $parent->set('children',$children);
                $this->findChildren($forum,$forums);
            }
        }
    }
    
}