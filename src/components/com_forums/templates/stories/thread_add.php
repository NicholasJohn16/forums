<?php defined('KOOWA') or die('Restricted access');?>

<data name="title">
	<?= sprintf(@text('COM-FORUMs-THREAD-NEW-THREAD'), @name($subject), @route($object->getURL())) ?>
</data>

<data name="body">
	<h4 class="entity-title">
		<?= @link($object->parent) ?>
	</h4>
	<div class="entity-body">
		<?= @helper('text.truncate', @content($object->body, array('exclude' => 'link')), array('length'=>200, 'consider_html' => true)); ?>
	</div>
	<?php if ($type == 'notification') : ?>
		<?php $commands->insert('viewpost', array('label' => @text('COM-FORUMS-THREAD-VIEW-THREAD')))->href($object->getURL())?>
	<?php endif; ?>
</data>
