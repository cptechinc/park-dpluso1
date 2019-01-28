<div>
    <?php if ($page->parent->id != $pages->get('/')->id) : ?>
        <div class="form-group">
            <a href="<?= $page->parent->url; ?>" class="btn btn-primary not-round">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back to Previous Menu
            </a>
        </div>
    <?php endif; ?>
    <div class="list-group">
        <?php foreach ($page->children('template!=redir') as $child) : ?>
            <a href="<?= $child->url; ?>" class="list-group-item">
                <h4 class="list-group-item-heading"><?= $child->title; ?></h4>
                <p class="list-group-item-text"><?= $child->summary; ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
