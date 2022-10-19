 <?php
   require_once './_inc/config.php';

    $routes = [
      '/' => [
        'GET' => 'home.php'
      ],
      '/post' => [
        'GET' => 'post.php',
        'POST' => '_inc/post-add.php',
      ],
      '/login' => [
        'GET' => 'login.php',
        'POST' => 'login.php',
      ],
      '/logout' => [
        'GET' => 'logout.php',
        'POST' => 'logout.php',
      ],
      '/user' => [
        'GET' => 'user.php',
      ],
      '/register' => [
        'GET' => 'register.php',
        'POST' => 'register.php',
      ],
      '/edit' => [
        'GET' => 'edit.php',
        'POST' => '_inc/post-edit.php',
      ],
      '/tag' => [
        'GET' => 'tag.php',
      ],
      '/delete' => [
        'GET' => 'delete.php',
        'POST' => '_inc/post-delete.php',
      ],
    ];

    $page = get_segment(1);
    $method = $_SERVER['REQUEST_METHOD'];

    $public = [
      'login', 'register'
    ];

    if ( ! $auth->isLogged() && !in_array($page, $public)) {
      redirect('/login');
    }

    
    if ( ! isset($routes["/$page"][$method])) {
      show_404();
    }
    require $routes["/$page"][$method];



    