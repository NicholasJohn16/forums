<?php defined('KOOWA') or die ?>

<?php $showToolbar = isset($showToolbar) ? $showToolbar : true; ?>
<?php $disabled = $post->enabled ? '' : 'forum-thread-disabled'; ?>
<?php $coverStyle = ($post->author && $post->author->coverSet()) ? "background-image:url('".$post->author->getCoverURL('medium')."')" : ''; ?>

<div class="row-fluid an-entity cid-<?= $post->id; ?>">

    <div class="forum-post-profile">
        <div class="forum-profile-banner" style="<?= $coverStyle ?>">

        </div>
        <div class="forum-profile-content">
            <div class="forum-profile-author">
                <?= @avatar($post->author, 'square') ?>    
                <h4 class="author-name"><?= @name($post->author) ?></h4>
            </div>

            <div class="forum-profile-description">
                
            </div>
        </div>
        <?php if($post->author): ?>
            <div class="forum-profile-actions an-socialgraph-stat">
                <!-- <div class="stat-count">
                    <?= $post->author->leaderCount ?>
                    <span class="stat-name">
                        <?= @text('COM-ACTORS-SOCIALGRAPH-LEADERS') ?>
                    </span>
                </div>
                <div class="stat-count">
                    <?= $post->author->followerCount ?>
                    <span class="stat-name">
                        <?= @text('COM-ACTORS-SOCIALGRAPH-FOLLOWERS') ?>
                    </span>
                </div>
                <div class="stat-count">
                    0
                    <span class="stat-name"><?= @text('COM-FORUMS-POST-COUNT') ?></span>
                </div> -->
            </div>
        <?php endif; ?>
    </div>
   
    <div class="forum-post-body <?= $disabled ?>">

        <h3 class="entity-title">
            <a class="forum-post-title" href="<?= @route($post->getThreadURL()) ?>">
                <?= $post->title; ?>
                <?php if($post->isUnread()): ?>
                    <small class="text-success"><?= @text('COM-FORUMS-POST-NEW') ?></small>
                <?php endif; ?>
            </a>
        </h3>

        <div class="entity-meta">
            <div class="an-meta">
                <?= @date($post->creationTime) ?>
            </div>
        </div>
        <div class="entity-description">
            <?= @content($post->body, array('exclude' => 'link')) ?>
        </div>

        <?php if($showToolbar): ?>
            <div class="entity-actions">
                <div class="btn-toolbar">
                    <?= @helper('ui.commands', @commands('toolbar')) ?>

                    <div class="pull-right">
                        <?= @helper('ui.commands', @commands('administration')) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="entity-meta clearfix">
            <div class="vote-count-wrapper pull-left" id="vote-count-wrapper-<?= $post->id ?>">
                <?= @helper('ui.voters', $post) ?>
            </div>

            <div class="pull-right">
                <?php if ($post->creationTime != $post->updateTime): ?>
                    <div class="an-meta">
                        <?= 'Edited ' . @date($post->updateTime) . ' by ' . @name($post->editor) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>