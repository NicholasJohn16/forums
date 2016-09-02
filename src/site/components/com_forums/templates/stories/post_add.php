<?php defined('KOOWA') or die('Restricted access');?>

<data name="title">
	<?= sprintf(@text('COM-FORUMS-STORY-POST-ADD'), @name($subject), @route($object->getURL()), $object->title) ?>
</data>

<data name="body">
    <h4 class="entity-title">
    	<?= @link($object)?>
    </h4>
    <div class="entity-body">
	    <?= @helper('text.truncate', @content($object->body, array('exclude' => 'link')), array('length'=>200, 'consider_html' => true, 'exact' => false)); ?>
	</div>
</data>
