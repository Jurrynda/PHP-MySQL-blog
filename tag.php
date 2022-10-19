<?php 
    $tag = urlencode( get_segment(2) );
    try {
        $result = get_posts_by_tag();
    } catch(PDOException $err) {
        $result = [];
    }
    
    include_once './_partials/header.php';
?>

<section>
    <h1 class="text-primary"><?= ucfirst($tag) ?></h1>
    <hr>
    <?php if( count($result)) : foreach($result as $post) : ?>

        <article id="post-<?= $post->id ?>" class="post">
            <header>
                <h2>
                    <a href="<?= $post->link ?>">
                        <?= $post->title ?>
                    </a>
                    <time datetime="<?= $post->date ?>">
                        <small>/ <?= $post->time ?></small>
                    </time>
                </h2>
                <?= include '_partials/tags.php' ?>
            </header>
            <div>
                <?= $post->teaser ?>
            </div>
            <div class="text-right">
                <a href="<?= $post->link ?>" class="read-more">
                    read more
                </a>
            </div>
        </article>

    <?php endforeach; else : ?>

        <p>There is nothing</p>

    <?php endif ?>
</section>

<?php 

    include_once './_partials/header.php';

?>
    

