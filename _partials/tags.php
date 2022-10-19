<?php if ($post->tags) : ?>
    <p>
        <?php foreach( $post->tag_links as $tag => $tag_link) : ?>
            <a href="<?= $tag_link ?>" class="btn btn-warning btn-sm">
                <?= $tag ?>
            </a>
        <?php endforeach ?>
    </p>
<?php endif ?>