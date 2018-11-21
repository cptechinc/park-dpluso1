<div class="alert alert-danger" role="alert">
    <?= $whsesession->status; ?>
</div>

<h4>Choose Your Function</h4>
<div>
    <div class="list-group">
        <?php foreach ($page->parent->children as $child) : ?>
            <a href="<?= $child->url; ?>" class="list-group-item">
                <h4 class="list-group-item-heading"><?= $child->title; ?></h4>
                <p class="list-group-item-text"><?= $child->summary; ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
