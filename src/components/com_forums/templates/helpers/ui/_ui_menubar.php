<?php defined('KOOWA') or die('Restricted access') ?>

<?php if (count($menubar->getCommands())) :?>
<ul class="nav nav-pills">
<?php foreach ($menubar->getCommands() as $command) : ?>
	<?php $attributes = $command->getAttributes(); ?>
	<?php $class = (array_key_exists('class', $attributes)) ? $attributes['class'] : ''; ?>
	<li class="<?= $class ?>">
		<?= @html('tag', 'a', $command->label, $attributes); ?>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>