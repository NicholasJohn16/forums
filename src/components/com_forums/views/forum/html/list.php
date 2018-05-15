<?php defined('KOOWA') or die('Restricted access'); ?>

<?php $locked = $forum->locked ? '<i class="icon-lock"></i>' : ''; ?>

<div class="media row-fluid">
    
    <a class="pull-left" href="<?= @route($forum->getURL()) ?>">
        <?php if($forum->getNewCount()): ?>
            <img class="media-object" src="media/com_forums/img/folder-green.png" alt="Folder New">
        <?php else: ?>
            <img class="media-object" src="media/com_forums/img/folder-blue.png" alt="Folder">
        <?php endif; ?>
    </a>

    <div class="media-body span6">
        <h4 class="media-heading">
            <a href="<?= @route($forum->getURL()) ?>">
                <?= $locked . $forum->name; ?>
            </a>
            <?php if($newCount = $forum->getNewCount()): ?>
                <span class="label label-success"><?= sprintf(@text('COM-FORUMS-FORUM-NEW-COUNT'), $newCount) ?></span>
            <?php endif; ?>
        </h4>
        <p><?= $forum->body; ?></p>
    </div>

    <div class="media-body span1 text-center">
        <div class="forum-stat-count"><?= @helper('humanize', $forum->getThreadCount()) ?></div>
        <div><?= @text('COM-FORUMS-FORUM-THREADS-COUNT') ?></div>
    </div>

    <div class="media-body span1 text-center">
        <div class="forum-stat-count"><?= @helper('humanize', $forum->getReplyCount()) ?></div>
        <div><?= @text('COM-FORUMS-FORUM-REPLY-COUNT') ?></div>
    </div>

    <?php if($forum->lastReply): ?>
        <div class="media-body span2">
            <p>Last Reply <a href="<?= @route($forum->lastReply->getThreadURL()) ?>">
                <?= $forum->lastReply->title ?></a> by <?= @name($forum->lastReplier) ?>
            </p>
        </div>  

        <div class="media-body span1">
            <?= @avatar($forum->lastReplier) ?>
        </div>
    <?php endif; ?>
</div>