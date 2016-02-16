<?php $thread = empty($thread) ? @service('repos:forums.thread')->getEntity()->reset() : $thread; ?>
<?php $icons = @helper('getThreadIcons'); ?>
<?php $checked = "checked"; ?>

<script src="com_forums/js/jquery.sceditor.bbcode.min.js"/>
<script src="com_forums/js/editor.js"/>

<link rel="stylesheet" href="media/com_forums/css/sceditor.bootstrap.css">

<form id="entity-form" method="post" action="<?=@route($thread->getURL())?>">
    
    <legend><?= @text('COM-FORUMS-THREAD-CREATE-NEW-THREAD') ?></legend>
    
    <label class="controll-label" for="thread_icon"><?= @text('COM-FORUMS-THREAD-THREAD-ICON') ?></label>
    <?php foreach($icons as $icon): ?>
        <label class="radio inline">
            <input type="radio" name="thread_icon" value="<?= $icon ?>" <?= $checked ?>>
            <img class="forum-thread-icon" src="media/com_forums/img/thread-icons/<?= $icon ?>.png">
        </label>
        <?php $checked = ""; ?>
    <?php endforeach; ?>
  
    <div class="control-group">
        <label class="control-label" for="name"><?= @text('COM-FORUMS-THREAD-TITLE') ?></label>
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
                autofocus>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="body"><?= @text('COM-FORUMS-THREAD-BODY') ?></label>
        <textarea rows="10" class="bbcode-editor input-block-level" name="body" tabindex="2" required></textarea>
    </div>
    
    <input type="hidden" name="pid" value="<?= $pid ?>"/>
    
    <a class="btn small" href="<?= @route($parent->getURL()) ?>" tabindex="4">
        <?= @text('LIB-AN-ACTION-CANCEL') ?>
    </a> 
    <button data-trigger="Add" class="btn btn-primary" tabindex="3">
        <?= @text('LIB-AN-ACTION-ADD') ?>
    </button>
    
</form>