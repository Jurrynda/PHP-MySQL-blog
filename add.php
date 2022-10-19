<?php 
    $page_title = 'Add new';
    
    include_once './_partials/header.php';
    
    if ( isset( $_SESSION['form-data'] ) ) {
        extract( $_SESSION['form-data'] );
        unset( $_SESSION['form-data'] );
    }
?>


    <form action="<?= BASE_URL ?>/_admin/add-item.php" method="post">
        <header class="post-header">
            <h1 class="text-secondary">
                Add new post
            </h1>
        </header>
        <div class="form-group">
            <input name="title" type="text" class="form-control" value="<?= $title ?: '' ?>">
        </div>
        <div class="form-group">
            <textarea name="text" type="text" rows="16" class="form-control" ><?= $text ?: '' ?></textarea>
        </div>
        <div class="form-group d-flex">
            <?php foreach(get_all_tags($tags) as $tag) : ?>
                <label class="checkbox text-primary ">
                    <input type="checkbox" name="tags[]" value="<?= $tag->id ?>"
                    <?= $tag->checked || in_array($tag->id, $tags ?: []) ? 'checked' : '' ?>>
                    <span class="mr-2"><?= $tag->tag ?></span>
                </label>
            <?php  endforeach ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add post</button>
            <span> 
                <a href="<?= BASE_URL ?>" class="text-secondary">Back</a>
            </span>
        </div>
    </form>


<?php 

    include_once './_partials/header.php';

?>
    

