<?php defined('KOOWA') or die('Restricted access'); ?>

<?php $highlight = $thread->pinned ? 'an-highlight' : ''; ?>
<?php $disabled = $thread->enabled ? '' : 'forum-thread-disabled'; ?>
<?php $locked = $thread->locked ? '<i class="icon-lock"></i>' : ''; ?>
<?php $threadIcon = $thread->getValue('thread_icon') ? $thread->getValue('thread_icon') : ($thread->locked ? 'lock' : 'papers'); ?>

<div class="media row-fluid an-entity <?= $highlight ?> <?= $disabled ?>">
    <a class="span1" href="<?= @route($thread->getURL()) ?>">
        <img class="forum-thread-icon" src="media/com_forums/img/thread-icons/<?= $threadIcon ?>.png" alt="Thread Icon">
    </a>

    <div class="media-body span6">
        <h4 class="media-heading">
          <a href="<?= @route($thread->getURL()) ?>">
            <?php echo $locked . $thread->name ?>
            <?php if($thread->isUnread()): ?>
                <span class="label label-success"><?= @text('COM-FORUMS-THREAD-NEW') ?></span>
            <?php endif; ?>
          </a>
        </h4>
        <p>Posted <span title="<?= $thread->creationTime->getDate() ?>"><?= @date($thread->creationTime) ?></span> by <?= @name($thread->author) ?></p>
    </div>

    <div class="media-body span1 text-center">
        <div class="forum-stat-count"><?= @helper('humanize', $thread->hits) ?></div>
        <div><?= @text('COM-FORUMS-THREAD-HIT-COUNT') ?></div>
    </div>

    <div class="media-body span1 text-center">
        <div class="forum-stat-count"><?= @helper('humanize', $thread->getReplyCount()) ?></div>
        <div><?= @text('COM-FORUMS-THREAD-REPLY-COUNT') ?></div>
    </div>

    <?php if($thread->lastReply): ?>
        <div class="media-body span2">
                <p>Last Reply
                    <a href="<?= @route($thread->lastReply->getThreadURL()) ?>">
                        <?= $thread->lastReply->title ?>
                    </a> by <?= @name($thread->lastReplier) ?>
                </p>
        </div>
        <div class="media-body span1">
            <?= @avatar($thread->lastReplier) ?>
        </div>
    <?php endif; ?>

</div>
