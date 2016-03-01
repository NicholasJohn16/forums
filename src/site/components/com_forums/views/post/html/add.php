<?php defined('KOOWA') or die ?>

<?= @helper('ui.menubar', array('menubar' => $menubar))?>

<ul class="breadcrumb">
    <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
    <li><a href="<?= @route($parent->parent->getURL()) ?>"><?= $parent->parent->name; ?></a> <span class="divider">/</span></li>
    <li><a href="<?= @route($parent->getURL()) ?>"><?= $parent->name; ?></a> <span class="divider">/</span></li>
    <li class="active"><?= @text('COM-FORUMS-THREAD-REPLY') ?></li>
</ul>

<div class="page-header">
	<h2><?= @text('COM-FORUMS-POST-REPLY-THREAD') ?></h2>
</div>

<?= @template('form') ?>