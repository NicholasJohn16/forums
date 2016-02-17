<?php defined('KOOWA') or die('Restricted access');?>

<?= @helper('ui.menubar', array('menubar' => $menubar))?>

<ul class="breadcrumb">
    <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
</ul>

<div class="btn-toolbar">
	<?= @helper('ui.commands', @commands('toolbar')) ?>
</div>

<div class="accordion">
    <?php foreach ($categories as $category): ?>
        <?php if (empty($category->parent)): ?>
            <?= @view('category')->layout('list')->category($category) ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>