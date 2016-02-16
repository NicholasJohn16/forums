<?php defined('KOOWA') or die('Restricted access');?>

<module position="sidebar-b" style="none"></module>

<ul class="breadcrumb">
  <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
  <li class="active"><a href="<?= @route($forum->getURL()) ?>"><?= $forum->name; ?></a> <span class="divider">/</span></li>
  <li class="active"><?= @text('COM-FORUMS-FORUM-EDIT') ?></li>
</ul>

<?= @template('form') ?>