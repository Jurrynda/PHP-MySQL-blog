<?php
    require_once '_inc/config.php';
    
    if ( !$auth->isLogged()) {
        redirect('/');
    }
    do_logout();


    flash()->success('logout success');
    redirect('/');