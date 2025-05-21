<?php defined('KOOWA') or die ?>

<?= @helper('ui.menubar', array('menubar' => $menubar))?>

<ul class="breadcrumb">
    <li><a href="<?= @route('view=forums') ?>"><?= @text('COM-FORUMS-FORUMS') ?></a> <span class="divider">/</span></li>
    <li><a href="<?= @route($thread->parent->parent->getURL()) ?>"><?= $thread->parent->parent->name; ?></a> <span class="divider">/</span></li>
    <li><a href="<?= @route($thread->parent->getURL()) ?>"><?= $thread->parent->name; ?></a> <span class="divider">/</span></li>
    <li class="active"><?= $thread->name; ?></li>
</ul>

<?= @helper('ui.toolbar', array('toolbar' => $toolbar)) ?>

<?php $editable = $thread->authorize('edit') ? 'an-editable' : '' ?>

<div class="an-entity <?= $editable ?>" data-url="<?= @route($thread->getURL()) ?>">
	<div class="entity-description-wrapper">
		<h1 class="entity-title"><?= $thread->title ?>
			<?php if($thread->isUnread()): ?>
				<span class="label label-success"><?= @text('COM-FORUMS-THREAD-NEW') ?></span>
			<?php endif; ?>
		</h1>
	</div>
</div>

<div class="an-entities">
	<?php foreach($thread->posts as $post): ?>
	    <?= @view('post')->layout('default')->post($post) ?>
	<?php endforeach; ?>
</div>	

<?php if($thread->authorize('reply')): ?>
	<div class="row-fluid">
		<div class="span12">
			<?= @view('post')->layout('form')->post(null)->parent($thread)->title($thread->title)->inline(true); ?>
		</div>
	</div>
<?php endif; ?>

<?= @pagination($thread->posts) ?>