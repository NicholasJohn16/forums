<?= @helper('ui.menubar', array('menubar' => $menubar))?>

<h2><?= @text('COM-FORUMS-YOUR-THREADS') ?></h2>

<div class="an-entities">
	
	<?php foreach($threads as $thread): ?>

		<?= @view('thread')->layout('list')->thread($thread) ?>

	<?php endforeach; ?>

</div>

<?= @pagination($threads) ?>