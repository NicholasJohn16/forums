<?php 


class ComForumsControllerBehaviorHashtagable extends ComHashtagsControllerBehaviorHashtagable
{
	public function extractHashtagTerms($text)
    {
        $filteredText = preg_replace('/\[[^[]*?(#[A-Fa-f0-9]{6}|#[A-Fa-f0-9]{3})[^]]*?\]/', '', $text);
        return parent::extractHashtagTerms($filteredText);
    }

}