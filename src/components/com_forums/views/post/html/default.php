<?php defined('KOOWA') or die ?>

<?php $showToolbar = isset($showToolbar) ? $showToolbar : true; ?>
<?php $disabled = $post->enabled ? '' : 'forum-thread-disabled'; ?>
<?php $coverStyle = ($post->author && $post->author->coverSet()) ? "background-image:url('".$post->author->getCoverURL('medium')."')" : ''; ?>


<?php $settings = null; ?>
<?php if ($post->author && $post->author->id): ?>
    <?php $settings = @service('repos:forums.setting')->find(['person_id' => $post->author->id]) ?>
<?php endif ?>

<div class="row-fluid an-entity cid-<?= $post->id; ?>">

    <div class="forum-post-profile span3 ">
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
        <?php if(false && $post->author): ?>
            <div class="forum-profile-actions an-socialgraph-stat">
                <div class="stat-count">
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
                </div>
            </div>
        <?php endif; ?>
    </div>
   
    <div class="forum-post-body span9 <?= $disabled ?>">

        <h3 class="entity-title">
            <a class="forum-post-title" href="<?= @route($post->getThreadURL()) ?>">
                <?= $post->title; ?>
                <?php if($post->isUnread()): ?>
                    <span class="label label-success"><?= @text('COM-FORUMS-POST-NEW') ?></span>
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
        <?php if ($settings && $settings->signature): ?>
            <div class="entity-signature">
                <hr>
                <?= @content($settings->signature, ['exclude' => ['link', 'medium' ]]) ?>
            </div>
        <?php endif ?>

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