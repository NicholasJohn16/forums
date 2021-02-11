<?php if (count($toolbar->getCommands())) : ?>

<?php $commands = $toolbar->getCommands(); ?>

<div class="btn-toolbar clearfix">
    <?php if ($locked = $commands->extract('locked')) :?>
        <?= @html('tag', 'span', $locked->label, $locked->getAttributes()) ?>
    <?php endif;?>

    <?php if ($reply = $commands->extract('reply')) :?>
        <?= @html('tag', 'a', $reply->label, $reply->getAttributes())->class('btn btn-primary') ?>
    <?php endif;?>

    <?php if($subscribe = $commands->extract('subscribe')): ?>
		<?= @html('tag', 'a', $subscribe->label, $subscribe->getAttributes())->class('btn btn-default') ?>
    <?php endif; ?>

    <?php if($unsubscribe = $commands->extract('unsubscribe')): ?>
		<?= @html('tag', 'a', $unsubscribe->label, $unsubscribe->getAttributes()) ?>
    <?php endif; ?>

    <?php if ($vote = $commands->extract('vote')) : ?>
         <?= @html('tag', 'a', $vote->label, $vote->getAttributes())->class('action-vote btn') ?>
    <?php elseif ($unvote = $commands->extract('unvote')) : ?>
         <?= @html('tag', 'a', $unvote->label, $unvote->getAttributes())->class('action-unvote btn') ?>
    <?php endif;?>

    <?php if ($commands->count() > 1) : ?>
    <div class="btn-group pull-right">
        <?= @helper('ui.dropdown', $commands)?>
    </div>
    <?php elseif ($commands->count() == 1) : ?>
        <?php $command = $commands->extract(); ?>
    	<div class="pull-right">
    	<span><?= @html('tag', 'a', $command->label, $command->getAttributes())->class('btn') ?></span>
    	</div>
    <?php endif; ?>
</div>
<?php endif;?>
