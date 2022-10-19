<?php
    require '../_inc/config.php';

    if ( !$auth->isLogged()) {
        redirect('/');
    }

    $post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    if ( !$post_id ) {
        flash()->error('hacker');
        redirect('back');
    }

    $query = $db->prepare("
        DELETE FROM posts
        WHERE id = :post_id
    ");

    $delete = $query->execute([
        'post_id' => $post_id
    ]);

    if ( !$delete ) {
        flash()->warning('sorry');
        redirect('back');
    }

    $query = $db->prepare("
        DELETE FROM posts_tags
        WHERE post_id = :post_id
    ");

    $query->execute([
        'post_id' => $post_id
    ]);

    flash()->success('deleted');
    redirect('/');
