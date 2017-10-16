<?php defined('KOOWA') or die ?>

<?php if(!empty($commands)): ?>

	<?php if ($vote = $commands->extract('vote')) : ?>
         <?= $helper->command($vote) ?>
    <?php elseif ($unvote = $commands->extract('unvote')) : ?>
         <?= $helper->command($unvote) ?>
    <?php endif;?> 

	<?php if($reply = $commands->extract('reply')): ?>
		<div class="btn-group">
			<?= $helper->command($reply); ?>
			<?= $helper->command($commands->extract('quickreply')) ?><
		</div>
		<div class="btn-group">
			<?= $helper->command($commands->extract('quote')) ?>
			<?= $helper->command($commands->extract('quickquote')) ?>
		</div>
	<?php endif; ?>

	<div class="btn-group">
		<?php foreach($commands as $command): ?>
			<?= $helper->command($command) ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>