<?php 
    try {
        $post = get_post(get_segment(2));
    } catch(PDOException $err) {
        $post = false;
    }
    
    if (! $post ) {
        flash() ->error("doesnt exist");
        redirect('/');
    }

    $page_title = 'Delete / ' . $post->title;
    
    include_once './_partials/header.php';
?>

<div class="row">
    <div class="col-sm-12">
        <h1>EDIT</h1>
        <hr>
        <form action="<?= BASE_URL ?>/_admin/delete-item.php" method="post">
            <header>
                <h3><?= $post->title ?></h3>
            </header>
            <div class="form-group">
                <p>
                    <?= $post->teaser ?>
                </p>
            </div>
            <div class="form-group">
                <input type="hidden" name="post_id" value="<?= $post->id ?>">
                <button type="submit" class="btn btn-danger">Delete post</button>
                <span> 
                    <a href="<?= get_post_link($post) ?>">Back</a>
                </span>
            </div>
        </form>
    </div>
</div>

<?php 

    include_once './_partials/header.php';

?>
    

