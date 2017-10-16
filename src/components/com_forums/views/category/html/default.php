<?php defined('KOOWA') or die('Restricted access'); ?>

<?= @helper('ui.menubar', array('menubar' => $menubar))?>

<ul class="breadcrumb">
    <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
    <li class="active"><?= $category->name; ?></li>
</ul>

<div class="clearfix">
	<?= @helper('ui.toolbar', $toolbar) ?>
</div>

<h1><?= $category->name ?></h1>

<?php foreach($category->forums as $forum): ?>
	<?= @view('forum')->layout('list')->forum($forum) ?>	
<?php endforeach; ?>