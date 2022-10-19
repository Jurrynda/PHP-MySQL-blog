<?php 
    
    include_once './_partials/header.php';
    $user = get_user( get_segment(2) );
    if ( !$user->id ) {
        redirect('/');
    }
    try {
        $result = get_posts_by_user( $user->uid );
    } catch(PDOException $err) {
        $result = [];
    }
?>

<section>
    
    <h2 class="text-primary"> <span class="h4 text-secondary">by</span> <?= $user->email ?></h2>
    <hr>
    <?php if( count($result)) : foreach($result as $post) : ?>

        <article id="post-<?= $post->id ?>" class="post">
            <header>
                <h2>
                    <a href="<?= $post->link ?>">
                        <?= $post->title ?>
                    </a>
                    <time datetime="<?= $post->date ?>">
                        <small class="date">/ <?= $post->time ?></small>
                    </time>
                </h2>
            </header>
            <div>
                <?= $post->teaser ?>
            </div>
            <div class="text-right">
                <a href="<?= $post->link ?>" class="read-more">
                    read more
                </a>
            </div>
            <?= include '_partials/tags.php' ?>
        </article>

    <?php endforeach; else : ?>

        <p>There is nothing</p>

    <?php endif ?>
</section>

<?php 

    include_once './_partials/header.php';

?>
    

