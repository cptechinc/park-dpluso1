<div>
    <div class="list-group">
        <?php foreach ($page->children as $child) : ?>
            <a href="<?= $child->url; ?>" class="list-group-item">
                <h4 class="list-group-item-heading"><?= $child->title; ?></h4>
                <p class="list-group-item-text"><?= $child->summary; ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
