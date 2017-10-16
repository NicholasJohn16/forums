<?= @helper('ui.menubar', array('menubar' => $menubar))?>

<ul class="breadcrumb">
    <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
    <li class="active"><?= @text('COM-FORUMS-YOUR-THREADS') ?></li>
</ul>

<div class="an-entities">
	
	<?php foreach($threads as $thread): ?>

		<?= @view('thread')->layout('list')->thread($thread) ?>

	<?php endforeach; ?>

</div>

<?= @pagination($threads) ?>