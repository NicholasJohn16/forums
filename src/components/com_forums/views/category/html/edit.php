<?php defined('KOOWA') or die('Restricted access');?>

<ul class="breadcrumb">
  <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
  <li class="active"><a href="<?= @route($category->getURL()) ?>"><?= $category->name; ?></a> <span class="divider">/</span></li>
  <li class="active"><?= @text('COM-FORUMS-CATEGORY-EDIT') ?></li>
</ul>

<?= @template('form') ?>