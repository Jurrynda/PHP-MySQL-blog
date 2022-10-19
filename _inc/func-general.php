<?php
   function get_segments() {
        $current_url = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's://' : '://') .
        $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $path = str_replace( BASE_URL, '', $current_url);
        $path = trim(parse_url( $path, PHP_URL_PATH), '/');

        $segments = explode('/', $path);

        return $segments;
    }

    function get_segment($index) {
        $segments = get_segments();
        return isset( $segments[ $index-1]) ? $segments[ $index-1] :false;
    }

       function show_404() {
        header("HTTP/1.0 404 Not Found");
        include_once "404.php";
        die();
    }

     function redirect($page, $status_code = 302) {
        if ($page == 'back') {
            $location = $_SERVER['HTTP_REFERER'];
        } else {
            $page = ltrim($page, '/');
            $location = BASE_URL . "/$page";
        }

        header("Location: $location", true, $status_code);
        die();
    }

    function asset($path, $base = BASE_URL.'/assets/') {
        $path = trim( $path, '/');
        return filter_var( $base.$path, FILTER_SANITIZE_URL);
    }