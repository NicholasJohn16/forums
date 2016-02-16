<?php defined('KOOWA') or die('Restricted access');?>

<div class="accordion-group forum-category-list">
    <div class="accordion-heading forum-category-heading">
        <a class="accordion-toggle" href="<?= @route($category->getURL()) ?>">
            <h4><?= $category->title ?></h4>
        </a>
    </div>
    <div class="accordion-body forum-category-body">
        <div class="accordion-inner">
            <?php foreach ($category->forums as $forum): ?>
                <?= @view('forum')->layout('list')->forum($forum) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>