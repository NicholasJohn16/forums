<?php defined('KOOWA') or die ?>

<h1><?= @text('COM-FORUMS-THREAD-MODERATE-THREAD') ?></h1>

<?php 
	$document = @service('anahita:document');
	$document->addScriptDeclaration("
		$(document).ready(function(){
			$('#tid').on('change', function(){
				if($('#tid').val() === '-1') {
					$('#target input').val(null);
					$('#target').removeClass('hidden');
				} else {
					$('#target input').val($('#tid').val());
					$('#target').addClass('hidden');
				}
			});
		});
	");
?>

<form id="entity-form" method="post" action="<?= @route($thread->getURL()) ?>">

	<fieldset>
		<legend><?= @text('COM-FORUMS-THREAD-MOVE-THREAD') ?></legend>
		<div class="control-group">
			<label for="forum" class="control-label">
				<?= @text('COM-FORUMS-THREAD-SELECT-PARENT') ?>
			</label>
			<div class="controls">
				<?= @helper('forums', $thread->parent) ?>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?= @text('COM-FORUMS-THREAD-MERGE-THREAD') ?></legend>
		<div class="control-group">
			<label for="merge" class="control-label">
				<?= @text('COM-FORUMS-THREAD-THREAD-TO-MERGE') ?>
			</label>
			<div class="controls">
				<?= @helper('threads', $thread, false) ?>
			</div>
		</div>
		<div class="control-group hidden" id="target">
			<label for="" class="control-label">
				<?= @text('COM-FORUMS-THREAD-TARGET-THREAD-ID') ?>
			</label>
			<div class="controls">
				<input type="text" name="target_id">
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>
			<?= @text('COM-FORUMS-THREAD-RENAME-THREAD') ?>	
		</legend>
		<div class="control-group">
			<label for="" class="control-label">
				<?= @text('COM-FORUMS-THREAD-NEW-NAME') ?>
			</label>
			<div class="controls">
				<input name="title" type="text" value="<?= $thread->title ?>" />
				<div class="checkbox">
				    <label>
				     	<input type="checkbox" name="update_replies"> <?= @text('COM-FORUMS-THREAD-UPDATE-ALL-REPLIES') ?>
				    </label>
			  </div>
			</div>
		</div>
	</fieldset>

	<input type="hidden" name="action" value="moderate">

	<a href="<?= @route($thread->getURL()) ?>" class="btn">
		<?= @text('LIB-AN-ACTION-CANCEL') ?>
	</a>

	<button type="submit" class="btn btn-primary">
		<?= @text('LIB-AN-ACTION-UPDATE') ?>
	</button>

</form>