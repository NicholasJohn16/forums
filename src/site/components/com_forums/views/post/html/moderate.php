<?php defined('KOOWA') or die('Restricted Access'); ?>

<?php 
	$document =& JFactory::getDocument();
	$document->addScriptDeclaration("
		
		$(document).ready(function(){
			
			$('#tid').on('change', function(){
				
				if($('#tid').val() === '-1') {
					$('#pid input').val(null);
					$('#pid').removeClass('hidden');
				} else {
					$('#pid input').val($('#tid').val());
					$('#pid').addClass('hidden');
				}
			});

		});

	");
?>

<h1><?= @text('COM-FORUMS-POST-MODERATE-POST') ?></h1>

<?= @view('post')->post($post)->set('showToolbar', false) ?>

<form id="entity-form" method="post" action="<?= @route($post->getURL()) ?>">

	<fieldset>
		<legend><?= @text('COM-FORUMS-POST-MOVE-POST') ?></legend>	
		<div class="control-group">
			<label class="control-label" for="tid">
				<?= @text('COM-FORUMS-POST-SELECT-PARENT') ?>
			</label>
			<div class="controls">
				<?= @helper('threads', $post->parent) ?>	
			</div>
		</div>

		<div class="control-group hidden" id="pid">
			<label class="control-label">
				<?= @text('COM-FORUMS-POST-THREAD-ID') ?>
			</label>
			<div class="controls">
				<input type="text" name="pid" value="<?= $post->parent->id ?>" />
			</div>
		</div>

	</fieldset>

	<input type="hidden" name="action" value="moderate">

		<a href="<?= @route($post->parent->getURL()) ?>" class="btn">
			<?= @text('LIB-AN-ACTION-CANCEL') ?>
		</a>

		<button type="submit" class="btn btn-primary">
			<?= @text('LIB-AN-ACTION-UPDATE') ?>
		</button>
		

</form>