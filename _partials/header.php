<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? "$page_title /" : '' ?> Blog</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="bg-secondary pt-5">

    <header class="container">
        <?= flash()->display() ?>

        <?php if ($auth->isLogged() ) : $user = get_user() ?>
        <nav class="navigation d-flex justify-content-between align-items-center">
            <div>
                <a href="<?= BASE_URL ?>" class="btn btn-primary">all posts</a>
                <a href="<?= BASE_URL ?>/user/<?= $user->id ?>" class="btn btn-primary">my posts</a>
                <a href="<?= BASE_URL ?>/post/new" class="btn btn-primary">create new</a>
            </div>
            <div>
                <span class="text-light"><?= $user->email ?></span>
                <a href="<?= BASE_URL ?>/logout" class="btn btn-warning">Logout</a>
            </div>
        </nav>
        <?php endif ?>
        

    </header>


    <main>
        <div class="container bg-light p-3">
