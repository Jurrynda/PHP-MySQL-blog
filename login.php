<?php 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $remember_me = $_POST['remember_me'] ? true : false;

        $login = $auth->login( $email, $password, $remember_me );
        
        if($login['error']) {
            flash()->error( $login['message'] );
        } else {
            do_login( $login );
            flash()->success('success');
            redirect('/');
        }

        if ($register['error']) {
            flash()->error( $register['message'] );
        } else {
            flash()->success($register['message']);
            redirect('/login');
        }
    }

    include_once '_partials/header.php' 
?>

<form method="post" action="" class="form-auth">
    <h2>Login</h2>
    <input value="<?= $_POST['email'] ?: '' ?>" type="text" name="email" class="form-control" placeholder="Enter your email">
    <input type="password" name="password" class="form-control" placeholder="Enter your password">
    <label class="from-check">
        <input type="checkbox" name="remember_me" id="remember_me" checked>
        Remeber me
    </label>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    <p>
        Don't have an account yet?
        <a href="<?= BASE_URL ?>/register">Sign up</a>
    </p>
</form>

<?php include '_partials/footer.php' ?>