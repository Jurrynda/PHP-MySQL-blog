<?php
    require '../_inc/config.php';

    if ( !$auth->isLogged()) {
        redirect('/');
    }

    if (! $data = validate_post()) {
        redirect('back');
    }

    extract( $data );

    $post = get_post($post_id, false);

    if ( !can_edit( $post )) {
        flash()->error('hacker');
        redirect('back');
    }

    $update_post = $db->prepare("
        UPDATE posts SET
        title = :title,
        text = :text
        WHERE id = :post_id
    ");

    $update_post->execute([
        'title' => $title,
        'text' => $text,
        'post_id' => $post_id
    ]);

    $delete_tags = $db->prepare("
        DELETE FROM posts_tags
        WHERE post_id = :post_id
    ");

    $delete_tags->execute([
        'post_id' => $post_id
    ]);

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

    if ( $update_post->rowCount() ) {
        flash()->success('success');
        redirect("/post/$post_id");
    }

    flash()->warning('we are sorry');
    redirect('back');
