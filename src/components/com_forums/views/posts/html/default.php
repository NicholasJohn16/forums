<?= @helper('ui.menubar', array('menubar' => $menubar))?>

<ul class="breadcrumb">
    <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
    <li class="active"><?= @text('COM-FORUMS-RECENT-POSTS') ?></li>
</ul>

<div class="an-entities">
	<?php foreach($posts as $post): ?>

		<?= @view('post')->layout('default')->post($post) ?>

	<?php endforeach; ?>
</div>

<?= @pagination($posts) ?>