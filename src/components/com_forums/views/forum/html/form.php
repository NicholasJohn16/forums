<?php defined('KOOWA') or die('Restricted access'); ?>

<?php $forum = empty($forum) ? @service('repos:forums.forum')->getEntity()->reset() : $forum; ?>

<form id="entity-form" data-behavoir="FormValidator" method="post" action="<?= @route($forum->getURL())?>">
    <fieldset>
        <legend><?= ($forum->persisted()) ? @text('COM-FORUMS-FORUM-EDIT') : @text('COM-FORUMS-FORUM-ADD') ?></legend>
        
        <div class="control-group">
            <label class="control-label" for="name"><?= @text('COM-FORUMS-FORUM-TITLE') ?></label>
            <div class="controls">
                <input 
                    data-validators="required" 
                    name="name" 
                    class="input-block-level" 
                    value="<?= @escape($forum->title) ?>" 
                    size="50" 
                    maxlenght="255"
                    tabindex="1"
                    required
                    type="text">
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="description"><?= @text('COM-FORUMS-FORUM-DESCRIPTION') ?></label>
            <div class="controls">
                <textarea 
                    data-validators="maxLength:5000" 
                    class="input-block-level" 
                    name="description" 
                    cols="50" 
                    rows="5" 
                    required
                    tabindex="2"><?= @escape( $forum->description ) ?></textarea>
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
            <label class="control-label" id="privacy" ><?= @text('COM-FORUMS-FORUM-ACCESS') ?></label>
            <div class="controls">
                <?= @helper('ui.privacy',array('entity' => $forum, 'auto_submit' => false, 'options' => $options, 'selected' => $forum->access)) ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" id="parent"><?= @text('COM-FORUMS-FORUM-PARENT') ?></label>
            <div class="controls">
                <?= @helper('parentCategory', $forum); ?>
            </div>
        </div>
        
        <?php if ($forum->persisted()): ?>
            <a class="btn" href="<?= @route($forum->getURL()) ?>">
                <?= @text('LIB-AN-ACTION-CANCEL') ?>
            </a> 
            <button class="btn btn-primary">
                <?= @text('LIB-AN-ACTION-UPDATE') ?>
            </button>
        <?php else: ?>
            <a href="<?= @route('view=forums') ?>" class="btn" name="cancel">
                <?= @text('LIB-AN-ACTION-CANCEL') ?>
            </a> 
            <button data-trigger="Add" class="btn btn-primary">
                <?= @text('LIB-AN-ACTION-ADD') ?>
            </button>
        <?php endif; ?>
        
    </fieldset>
</form>