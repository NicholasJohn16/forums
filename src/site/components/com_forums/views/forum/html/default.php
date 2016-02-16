<?php defined('KOOWA') or die('Restricted access'); ?>
    
    <?= @helper('ui.menubar', array('menubar' => $menubar))?>

    <ul class="breadcrumb">
        <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
        <li><a href="<?= @route($forum->parent->getURL()) ?>"><?= $forum->parent->name ?></a> <span class="divider">/</span></li>
        <li class="active"><?= $forum->name; ?></li>
    </ul>

    <?= @helper('ui.toolbar', array('toolbar' => $toolbar)) ?>

    <div class="an-entity">
        <h2 class="entity-title"><?php echo $forum->name; ?></h2>
    </div>

    <?php //foreach($forums as $forum) : ?>
        <? //= @view('forum')->layout('list')->forum($forum) ?>
    <?php //endforeach; ?>
    <div class="an-entities">
        <?php foreach($threads as $thread): ?>
            <?= @view('thread')->layout('list')->thread($thread) ?>
        <?php endforeach; ?>
    </div>

<?= @pagination($threads) ?>
