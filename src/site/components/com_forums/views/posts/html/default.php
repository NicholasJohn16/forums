<?= @helper('ui.menubar', array('menubar' => $menubar))?>

<h2><?= @text('COM-FORUMS-RECENT-POSTS') ?></h2>

<div class="an-entities">
	<?php foreach($posts as $post): ?>

		<?= @view('post')->layout('default')->post($post) ?>

	<?php endforeach; ?>
</div>

<?= @pagination($posts) ?>