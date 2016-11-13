<?php

$autoloader = include JPATH_VENDOR.'/autoload.php';
$autoloader->add('Decoda', JPATH_LIBRARIES . '/decoda');

class ComForumsBlock extends \Decoda\Filter\BlockFilter {
    function __construct() {

        $align = array(
            'align' => array(
                'htmlTag' => 'div',
                'displayType' => 2,
                'allowedTypes' => 3,
                'attributes' => array(
                    'default' => array('/^(?:left|center|right|justify)$/i', 'text-{default}')
                ),
                'mapAttributes' => array(
                    'default' => 'class'
                )
            ),
            'left' => array(
                'htmlTag' => 'div',
                'displayType' => 2,
                'allowedTypes' => 3,
                'htmlAttributes' => array(
                    'class' => 'text-left'
                )
            ),
            'right' => array(
                'htmlTag' => 'div',
                'displayType' => 2,
                'allowedTypes' => 3,
                'htmlAttributes' => array(
                    'class' => 'text-right'
                )
            ),
            'center' => array(
                'htmlTag' => 'div',
                'displayType' => 2,
                'allowedTypes' => 3,
                'htmlAttributes' => array(
                    'class' => 'text-center'
                )
            )
        );

        $this->_tags = array_merge($this->_tags, $align);
        parent::__construct();
    }
}

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
        $decoda->setStrict(false);
        // $decoda->defaults();
        $decoda->addFilter(new \Decoda\Filter\DefaultFilter());
        $decoda->addFilter(new \Decoda\Filter\EmailFilter());
        $decoda->addFilter(new \Decoda\Filter\ImageFilter());
        $decoda->addFilter(new \Decoda\Filter\UrlFilter());
        $decoda->addFilter(new \Decoda\Filter\TextFilter());
        $decoda->addFilter(new \Decoda\Filter\VideoFilter());
        $decoda->addFilter(new \Decoda\Filter\CodeFilter());
        $decoda->addFilter(new \Decoda\Filter\QuoteFilter());
        $decoda->addFilter(new \Decoda\Filter\ListFilter());
        $decoda->addFilter(new \Decoda\Filter\TableFilter());
        $decoda->addFilter(new ComForumsBlock);
    
        $decoda->addHook(new \Decoda\Hook\ClickableHook());

        $parsed = $decoda->parse();
        $html = str_replace('<br />', '', $parsed);

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
