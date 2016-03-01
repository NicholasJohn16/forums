<?php defined('KOOWA') or die ?>

<ul class="breadcrumb">
    <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
    <li><a href="<?= @route($post->parent->parent->getURL()) ?>"><?= $post->parent->parent->name; ?></a> <span class="divider">/</span></li>
    <li><a href="<?= @route($post->parent->getURL()) ?>"><?= $post->parent->name; ?></a> <span class="divider">/</span></li>
    <li class="active">Edit</li>
</ul>

<div class="page-header">
	<h2><?= @text('COM-FORUMS-POST-EDIT-POST') ?></h2>
</div>

<?= @template('form') ?>