<?php defined('KOOWA') or die('Restricted access');?>

<data name="title">
	<?= sprintf(@text('COM-FORUMs-THREAD-NEW-THREAD'), @name($subject), @route($object->getURL())) ?>
</data>

<data name="body">
	<h4 class="entity-title">
		<?= @link($object->parent) ?>
	</h4>
	<div class="entity-body">
		<?= @content(@helper('text.truncate', @escape($object->body), array('length'=>200, 'consider_html' => true)), array('exclude' => 'link')); ?>
	</div>
</data>