<?php 
    try {
        $result = get_posts();
    } catch(PDOException $err) {
        $result = [];
    }
    
    include_once './_partials/header.php';
?>

<section>
    <h1 class="text-secondary">This is a blog</h1>
    <hr>
    <?php if( count($result)) : foreach($result as $post) : ?>

        <article id="post-<?= $post->id ?>" class="vr">
            <header>
                <h2>
                    <a href="<?= $post->link ?>">
                        <?= $post->title ?>
                    </a>
                    <time datetime="<?= $post->date ?>">
                        <small class="h6 text-secondary"> <?= $post->time ?></small>
                    </time>
                </h2>
                 <?php include '_partials/tags.php' ?>
            </header>
            <div >
                <?= $post->teaser ?>
            </div>
            <div class="mt-3">
                <a href="<?= $post->link ?>" >
                    read more
                </a>
            </div>
            
            <hr>
        </article>

    <?php endforeach; else : ?>

        <p>There is nothing</p>

    <?php endif ?>
</section>

<?php 

    include_once './_partials/header.php';

?>
    

