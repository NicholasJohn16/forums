<?php defined('KOOWA') or die('Restricted access');?>

<module position="sidebar-b" style="none"></module>

<ul class="breadcrumb">
  <li><a href="forums"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
  <li class="active"><?= @text('COM-FORUMS-FORUM-ADD') ?></li>
</ul>

<?= @template('form') ?>