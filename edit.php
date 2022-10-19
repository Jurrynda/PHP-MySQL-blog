<?php 
    try {
        $post = get_post(get_segment(2), false);
    } catch(PDOException $err) {
        $post = false;
    }
    
    if (! $post ) {
        flash() ->error("doesnt exist");
        redirect('/');
    }

    $page_title = 'Edit / ' . $post->title;
    
    include_once './_partials/header.php';
?>


    <h1>Edit</h1>
    <hr>
    <form action="<?= BASE_URL ?>/_admin/edit-item.php" method="post">
        <header class="post-header">
            <h1>
                Edit: <span class="text-primary"><?= $post->title ?></span>
            </h1>
        </header>
        <div class="form-group">
            <input name="title" type="text" class="form-control" value="<?= $post->title ?>">
        </div>
        <div class="form-group">
            <textarea name="text" type="text" rows="16" class="form-control" ><?= $post->text ?></textarea>
        </div>
        <div class="form-group d-flex">
            <?php  foreach(get_all_tags( $post->id ) as $tag) : ?>
                <label class="checkbox text-primary ">
                    <input type="hidden" value="<?= $post->id ?>" name="post_id">
                    <input type="checkbox" name="tags[]" value="<?= $tag->id ?>"
                    <?= isset($tag->checked) && $tag->checked ? 'checked' : '' ?>>
                    <span><?= $tag->tag ?></span>
                </label>
            <?php  endforeach ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit post</button>
            <span> 
                <a href="<?= get_post_link($post) ?>">Back</a>
            </span>
        </div>
    </form>
 

<?php 

    include_once './_partials/header.php';

?>
    

