<?php
    require '../_inc/config.php';

    if ( !$auth->isLogged()) {
        redirect('/');
    }

    if (! $data = validate_post()) {
        redirect('back');
    }

    extract( $data );
    $slug = slugify( $title );

    
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    $query = $db->prepare("
        INSERT INTO posts (user_id, title, text, slug)
        VALUES (:uid, :title, :text, :slug)
    ");

    $insert = $query->execute([
        'uid' => get_user()->uid,
        'title' => $title,
        'text' => $text,
        'slug' => $slug
    ]);

    if ( !$insert ) {
        flash()->warning('sorry');
        redirect('back');
    }

    $post_id = $db->lastInsertId();

    if (isset( $tags ) && $tags = array_filter( $tags )) {
        foreach( $tags as $tag_id) {
            $insert_tags = $db->prepare("
                INSERT INTO posts_tags
                VALUES (:post_id, :tag_id)
            ");

            $insert_tags->execute([
                'post_id' => $post_id,
                'tag_id' => $tag_id
            ]);
        }
    }

    flash()->success('created');

    redirect("post/$post_id/$slug");
