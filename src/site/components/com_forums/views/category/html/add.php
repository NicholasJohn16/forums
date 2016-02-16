<?php defined('KOOWA') or die('Restricted access');?>

<ul class="breadcrumb">
  <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
  <li class="active"><?= @text('COM-FORUMS-CATEGORY-ADD') ?></li>
</ul>

<?= @template('form') ?>