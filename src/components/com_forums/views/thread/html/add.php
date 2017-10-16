<?php defined('KOOWA') or die('Restricted access'); ?>

<ul class="breadcrumb">
  <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
    <li><a href="<?= @route($parent->parent->getURL()) ?>"><?= $parent->parent->name ?></a> <span class="divider">/</span></li>  
  <li><a href="<?= @route($parent->getURL()) ?>"><?= $parent->name ?></a> <span class="divider">/</span></li>
  <li class="active"><?= @text('COM-FORUMS-THREAD-ADD') ?></li>
</ul>

<?= @template('form') ?>