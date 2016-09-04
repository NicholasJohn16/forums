<?php

$autoloader = include JPATH_VENDOR.'/autoload.php';
$autoloader->add('Decoda', JPATH_LIBRARIES . '/decoda');

class PlgContentfilterBbcode extends PlgContentfilterAbstract
{
	protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'priority' => KCommand::PRIORITY_LOW,
        ));

        parent::_initialize($config);
    }

    public function filter($text)
    {
		$config = array('escapeHtml' => false);
        $decoda = new Decoda\Decoda($text, $config);
        $decoda->defaults();
        $decoda->setStrict(false);
        // $decoda->removeFilter('Video');
        $decoda->removeHook('Censor');
        //$decoda->removeFilter('Url');
        $html = $decoda->parse();

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
    }


}
