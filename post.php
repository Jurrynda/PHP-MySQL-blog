<?php 
    $id = get_segment(2);

    if ($id === 'new') {
        include_once 'add.php';
        die();
    }

    try {
        $post = get_post( $id );
    } catch(PDOException $err) {
        $post = false;
    }
    
    if (! $post ) {
        flash() ->error("doesnt exist");
        redirect('/');
    }

    $page_title = $post->title;
    
    include_once './_partials/header.php';
?>

<section>
    <article id="post-<?= $post->id ?>">
        <header>
            <h2>
                <a href="<?= $post->link ?>" class="mx-auto">
                    <?= $post->title ?>
                </a>
                <time datetime="<?= $post->date ?>">
                   <small class="h6 text-secondary"> <?= $post->time ?></small>
                </time>
                <?php if (can_edit($post)) : ?>
                <div>
                    <a href="<?= get_post_link($post, 'edit') ?>" class="btn btn-success">
                        Edit
                    </a>
                    <a href="<?= get_post_link($post, 'delete') ?>" class="btn btn-danger">
                        Delete
                    </a>
                </div>
                <?php endif ?>
                
            </h2>
        </header>
        <hr>
        <div class="text-secondary">
            <?= $post->text ?>
            
        </div>
        <hr>
        <footer class="d-flex justify-content-between">
            <?= include '_partials/tags.php' ?>
            <p class="mt-3">
                <small> written by 
                    <a href="<?= $post->user_link ?>"><?= $post->email ?></a>
                </small>
            </p>
        </footer>
    </article>
</section>

<?php 

    include_once './_partials/footer.php';

?>