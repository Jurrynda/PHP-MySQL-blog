<?php 
 function get_post($id = 0, $auto_format = true) {
        if ( !$id && !$id = get_segment(2) ) {
            return false;
        } else if ( ! filter_var( $id, FILTER_VALIDATE_INT)) {
            return false;
        }

        global $db;

        $query = $db->prepare("
            SELECT p.*, u.email, GROUP_CONCAT(t.tag SEPARATOR '|') AS tags
            FROM posts p
            LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
            LEFT JOIN tags t ON (t.id = pt.tag_id)
            LEFT JOIN phpauth_users u ON (p.user_id = u.id)
            WHERE p.id = :id
            GROUP BY p.id
        ");

        $query->execute([ 'id' => $id ]);

        if( $query->rowCount() === 1) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if( $auto_format) {
                $result = format_post($result);
            } else {
                $result = (object) $result;
            }
        } else {
            $result = [];
        }
        return $result;
    }

    function get_posts($auto_format = true) {
        global $db;

        $query = $db->query("
            SELECT p.*, GROUP_CONCAT(t.tag SEPARATOR '|') AS tags
            FROM posts p
            LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
            LEFT JOIN tags t ON (t.id = pt.tag_id)
            GROUP BY p.id
        ");

        if( $query->rowCount()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if( $auto_format) {
                $result = array_map('format_post', $result);
            }
        } else {
            $result = [];
        }
        return $result;
    };

    function format_post($post) {
        $post = array_map('trim', $post);

        $post['tags'] = $post['tags'] ? explode('|', $post['tags']) : [];
        if ($post['tags']) foreach($post['tags'] as $tag) {
            $post['tag_links'][$tag] = BASE_URL . '/tag/' . urlencode($tag);
            $post['tag_links'][$tag] = filter_var($post['tag_links'][$tag], FILTER_SANITIZE_URL);
        }

        $post['link'] = get_post_link( $post );
        

        $post['timestamp'] = strtotime($post['created_at']);
        $post['time'] = date('j M Y, G:i', $post['timestamp']);
        $post['date'] = date('Y-m-d', $post['timestamp']);

        $post['teaser'] = limit_text($post['text'], 40);

        $post['email'] = filter_var( $post['email'], FILTER_SANITIZE_EMAIL );
        $post['user_link'] = BASE_URL . '/user/' . $post['user_id'];
        $post['user_link'] = filter_var($post['user_link'], FILTER_SANITIZE_URL);

        return (object)$post;
    }

    function get_posts_by_tag($tag = '', $auto_format = true) {
        if ( !$tag && !$tag = get_segment(2) ) {
            return false;
        } 
        
        $tag = urldecode( get_segment(2) );
        
        global $db;

        $query = $db->prepare("
            SELECT p.*, GROUP_CONCAT(t.tag SEPARATOR '|') AS tags
            FROM posts p
            LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
            LEFT JOIN tags t ON (t.id = pt.tag_id)
            WHERE t.tag = :tag
            GROUP BY p.id
        ");

        $query->execute([ 'tag' => $tag ]);

        if( $query->rowCount()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if( $auto_format) {
                $result = array_map('format_post', $result);
            }
        } else {
            $result = [];
        }
        return $result;
    }

    function get_posts_by_user($user_id = '', $auto_format = true) {
        if ( !$user_id  ) {
            return false;
        } 
                
        global $db;

        $query = $db->prepare("
            SELECT p.*, u.email, GROUP_CONCAT(t.tag SEPARATOR '|') AS tags
            FROM posts p
            LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
            LEFT JOIN tags t ON (t.id = pt.tag_id)
            LEFT JOIN phpauth_users u ON (p.user_id = u.id)
            WHERE p.user_id = :uid
            GROUP BY p.id
        ");

        $query->execute([ 'uid' => $user_id ]);

        if( $query->rowCount()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if( $auto_format) {
                $result = array_map('format_post', $result);
            }
        } else {
            $result = [];
        }
        return $result;
    }

    function get_post_link( $post, $type = 'post' ) {
        if ( is_object($post)) {
            $id = $post->id;
            $slug = $post->slug;
        } else {
            $id = $post['id'];
            $slug = $post['slug'];
        }

        $link = BASE_URL . "/$type/$id";
        if ( $type === 'post') {
            $link .= "/$slug";
        }
        $link = filter_var($link, FILTER_SANITIZE_URL);  
        
        return $link;
    }

    function get_all_tags ($post_id = 0) {
        global $db;

        $query = $db->query("
            SELECT * FROM tags
        ");

        $result = $query->rowCount() ? $query->fetchAll( PDO::FETCH_OBJ) : [];

        if ($post_id) {
            $query = $db->prepare("
                SELECT t.id FROM tags t
                JOIN posts_tags pt ON t.id = pt.tag_id
                WHERE pt.post_id = :pid
                ORDER BY tag ASC
            ");
        }

        $query->execute([
                'pid' => $post_id
        ]);

        if ($query->rowCount()) {
            $tags_for_post = $query->fetchAll(PDO::FETCH_COLUMN);

            foreach($result as $key => $tag) {
                if (in_array($tag->id, $tags_for_post)) {
                    $result[$key]->checked = true;
                }
            }
        }

        return $result;
    }

    function validate_post() {
        $title = filter_input( INPUT_POST, 'title');
        $text = filter_input( INPUT_POST, 'text');
        $tags = filter_input( INPUT_POST, 'tags', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        if ( isset($_POST['post_id']) ) {
            $post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
            if ( !$post_id ) {
                flash()->error('hacker');
            }
        } else {
            $post_id = false;
        }

        

        if ( !$title = trim($title) ) {
            flash()->error('you forgot your title');
            echo $title;
        }

        if ( !$text = trim($text) ) {
            flash()->error('you forgot your text');
        }

        if ( !$tags = array_filter( $tags ) ) {
            echo 'no tags';
        }

        if ( flash()->hasMessages()) {
            $_SESSION['form-data'] = [
                'title' => $title,
                'text' => $text,
                'tags' => $tags ?: [],
            ];
            return false;
        }

        // return compact(
        //     'post_id', 'title', 'text', 'tags',
        //     $post_id, $title, $text, $tags
        // );
        return [
            'post_id' => $post_id,
            'title' => $title,
            'text' => $text,
            'tags' => $tags
        ];
    }

    function slugify($text, $divider = '-') {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        $text = preg_replace('~[^-\w]+~', '', $text);

        $text = trim($text, $divider);

        $text = preg_replace('~-+~', $divider, $text);

        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    