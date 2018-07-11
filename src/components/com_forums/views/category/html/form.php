<?php defined('KOOWA') or die('Restricted access'); ?>

<?php $category = empty($category) ? @service('repos:forums.category')->getEntity()->reset() : $category; ?>

<form id="entity-category" method="post" action="<?= @route($category->getURL()) ?>">

	<fieldset>

		<legend><?= ($category->persisted()) ? @text('COM-FORUMS-CATEGORY-EDIT') : @text('COM-FORUMS-CATEGORY-ADD') ?></legend>
	
		<div class="control-group">
			<label for="name" class="control-label"><?= @text('COM-FORUMS-CATEGORY-TITLE') ?></label>
            <div class="controls">
			     <input name="name" class="input-block-level" value="<?= @escape($category->title) ?>" size="50" maxlength="255" tabindex="1" type="text"/>
            </div>
		</div>

        <?php 
        $options = new KConfig(array(
                LibBaseDomainBehaviorPrivatable::GUEST =>   translate('LIB-AN-PRIVACYLABEL-PUBLIC'),
                LibBaseDomainBehaviorPrivatable::REG =>     translate('LIB-AN-PRIVACYLABEL-REGISTERED'),
                // LibBaseDomainBehaviorPrivatable::SPECIAL => translate('LIB-AN-PRIVACYLABEL-SPECIAL'),
                LibBaseDomainBehaviorPrivatable::ADMIN =>   translate('LIB-AN-PRIVACYLABEL-ADMIN')
            ));
        ?>

		<div class="control-group">
            <label class="control-label" id="privacy" ><?= @text('COM-FORUMS-CATEGORY-ACCESS') ?></label>
            <div class="controls">
                <?= @helper('ui.privacy', array('entity' => $category, 'auto_submit' => false, 'options' => $options, 'selected' => $category->access )) ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" id="parent"><?= @text('COM-FORUMS-CATEGORY-PARENT') ?></label>
            <div class="controls">
                <?= @helper('parentForum', $category); ?>
            </div>
        </div>

        <?php if ($category->persisted()): ?>
            <a class="btn" href="<?= @route($category->getURL()) ?>">
                <?= @text('LIB-AN-ACTION-CANCEL') ?>
            </a> 
            <button class="btn btn-primary">
                <?= @text('LIB-AN-ACTION-UPDATE') ?>
            </button>
        <?php else: ?>
            <a href="<?= @route('view=forums') ?>" class="btn"  name="cancel">
                <?= @text('LIB-AN-ACTION-CANCEL') ?>
            </a> 
            <button data-trigger="Add" class="btn btn-primary">
                <?= @text('LIB-AN-ACTION-ADD') ?>
            </button>
        <?php endif; ?>

	</fieldset>

</form>