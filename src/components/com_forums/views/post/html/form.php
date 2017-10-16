<?php defined('KOOWA') or die('Restricted access'); ?>

<?php $post = empty($post) ? @service('repos://site/forums.post')->getEntity()->reset() : $post; ?>
<?php $parent_id = empty($parent) ? $post->parent->id : $parent->id ?>
<?php $body = empty($body) ? $post->body : $body; ?>
<?php $title = empty($title) ? $post->title : $title ?>
<?php $inline = isset($inline) ? $inline : false; ?>

<script src="com_forums/js/jquery.sceditor.bbcode.min.js"/>
<script src="com_forums/js/editor.js" />

<link rel="stylesheet" href="media/com_forums/css/sceditor.bootstrap.css">

<form id="entity-form" data-behavoir="FormValidator" method="post" action="<?= @route($post->getURL())?>">
    
    <div class="control-group">

        <?php if(!$inline): ?>
            <label class="control-label" for="name"><?= @text('COM-FORUMS-POST-TITLE') ?></label>
        <?php endif; ?>

        <div class="controls">
            <input 
                data-validators="required" 
                name="name" 
                class="input-block-level" 
                size="50" 
                maxlenght="255"
                tabindex="1"
                type="text"
                required
                value="<?= $title ?>">
        </div>
    </div>
        
    <div class="control-group">
        <?php if(!$inline): ?>
            <label class="control-label" for="body"><?= @text('COM-FORUMS-POST-BODY') ?></label>
        <?php endif; ?>

        <textarea rows="10" class="bbcode-editor input-block-level" name="body"><?= $body ?></textarea>
    </div>
    
    <input type="hidden" name="pid" value="<?= $parent_id ?>"/>

    <?php if ($post->persisted()): ?>
        <a class="btn" href="<?= @route($post->getThreadURL()) ?>">
            <?= @text('LIB-AN-ACTION-CANCEL') ?>
        </a> 
        <button class="btn btn-primary">
            <?= @text('LIB-AN-ACTION-UPDATE') ?>
        </button>
    <?php else: ?>

        <?php if(!$inline): ?>
            <a class="btn small" href="<?= @route($parent->getURL()) ?>" >
                <?= @text('LIB-AN-ACTION-CANCEL') ?>
            </a> 
        <?php endif; ?>

        <button type="submit" data-trigger="Add" class="btn btn-primary">
            <?= @text('LIB-AN-ACTION-ADD') ?>
        </button>
    <?php endif; ?>
    
</form>