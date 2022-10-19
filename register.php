<?php 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $password_repeat = $_POST['password_repeat'];

        $register = $auth->register( $email, $password, $password_repeat);
        if ($register['error']) {
            flash()->error( $register['message'] );
        } else {
            flash()->success('acount created');
            redirect('/login');
        }
        echo '<pre>';
            print_r($register);
        echo '</pre>';
    }

    include_once '_partials/header.php' 
?>

<form method="post" action="" class="form-auth">
    <h2>Register</h2>
    <input value="<?= $_POST['email'] ?: '' ?>" type="text" name="email" class="form-control" placeholder="Enter your email">
    <input type="password" name="password" class="form-control" placeholder="Enter your password">
    <input type="password" name="password_repeat" class="form-control" placeholder="Repeat your password">
    <button class="btn btn-lg btn-primary btn-block" type="submit">register</button>
    <p>
        Already have an acount?
        <a href="<?= BASE_URL ?>/login">sign-in</a>
    </p>
</form>

<?php include '_partials/footer.php' ?>