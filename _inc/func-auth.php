<?php
    function do_login ($data) {
        global $auth_config;

        setcookie(
            $auth_config->cookie_name, 
            $data['hash'], 
            $data['expire'], 
            $auth_config->cookie_path, 
            $auth_config->cookie_domain, 
            $auth_config->cookie_secure, 
            $auth_config->cookie_http
        );
    }

    function do_logout () {
        global $auth;
        
        return ($auth->logout($auth->getCurrentSessionHash()));
    }

    function get_user ( $user_id = 0) {
        global $auth;

        if ( !$user_id && $auth->isLogged()){
            $user_id = $auth->getSessionUID($auth->getCurrentSessionHash());
        }

        return (object) $auth->getUser($user_id);
    }

    function can_edit( $post ) {
        global $auth;

        if ( !$auth->isLogged()) {
            return false;
        }

        if (is_object( $post )) {
            $post_user_id = (int) $post->user_id;
        } else {
            $post_user_id = (int) $post['user_id'];
        }

        $user = get_user();

        return $post_user_id === $user->uid;
    }