<?php defined('KOOWA') or die ?>

<form class="inline-edit" action="<?= @route($thread->getURL()) ?>" method="post">

	<div class="input-append">
		<input type="text" name="name" value="<?= $thread->name ?>">
		<button class="btn btn-primary" type="submit">
			<?= @text('LIB-AN-ACTION-UPDATE') ?>
		</button>
		<button data-trigger="EditableCancel" href="<?= @route($thread->getURL()) ?>" class="btn" type="button">
			<?= @text('LIB-AN-ACTION-CANCEL') ?>
		</button>
	</div>

</form>