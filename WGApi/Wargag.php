<?php

class Wargag {

    var $url = 'https://api.worldoftanks.ru/wgn/wargag/content/';
    var $urlAuth = 'https://api.worldoftanks.ru/wot/auth/login/';
    var $application_id = 'a1a5502d2265a9846fc71927679f46f7';

    public function getContent($type = false) {

        $url = $this->url;
        $data = array(
            'application_id' => $this->application_id,
            'type' => $type ? $type : '',
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
//        $data = json_decode($result);
//        self::clearCache();
        $data = self::addCache('dataWargag', $result);

        if ($data->status == 'ok')
            $responce = $data->data;
        else
            $responce = false;

        return $responce;
    }

    public function putContent($type = false) {

        $url = $this->url;
        
        for ($i = 1; $i <= 2; $i++) {

            $data = array(
                'application_id' => $this->application_id,
                'type' => $type ? $type : '',
                'order_by' => '-date',
                'page_no' => $i
            );

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $data = json_decode($result);


            if ($data->status == 'ok') {
                foreach ($data->data as $post) {
                    $args = array(
                        'meta_query' => array(
                            array(
                                'key' => 'wg_id',
                                'value' => $post->content_id
                            )
                        )
                    );

                    $postExist = get_posts($args);

                    if (!$postExist) {
                        $count_posts = wp_count_posts();

                        $published_posts = $count_posts->publish;

                        switch ($post->type) {
                            case 'picture':
                                $title = !empty($post->description) ? $post->description : 'Картинка №' . $published_posts;
                                $content = '<img class="wargagPicture" src="' . $post->media_url . '"><br><p>' . $post->description . '</p><br>';
                                break;

                            case 'quote':
                                $title = 'Цитата №' . $published_posts;
                                $content = '<p>' . $post->description . '</p>';
                                break;

                            case 'video':
                                $title = 'Видео №' . $published_posts;
                                $content = '<iframe type="text/html" width="80%" height="60%" src="' . $post->media_url . '" frameborder="0" ></iframe>';
//                            $go = true;
                                break;

                            default :
                                $title = $post->type . ' №' . $published_posts;
                                $content = $post->media_url;
                                break;
                        }

//                    if(isset($go) && $go){
                        $my_post = array(
                            'post_title' => $title,
                            'post_content' => $content,
                            'post_status' => 'publish',
                            'post_author' => 1,
                            'tax_input' => array('WARGAG' => array(69))
                        );

                        $newPostID = wp_insert_post($my_post);
                        wp_set_object_terms($newPostID, $post->type, 'wargag');

                        add_post_meta($newPostID, 'wg_id', $post->content_id);
                        add_post_meta($newPostID, 'created_at', $post->created_at);
//                        add_post_meta($newPostID, 'wg_post_rating', $post->rating);
//                    break;
//                    }
                    }
                }
            }
        }
    }

    public static function authWG($accessToken, $nickName, $accountId) {
        session_start();

        if (isset($_SESSION['User']))
            unset($_SESSION['User']);

        $_SESSION['User']['nickName'] = $nickName;
        $_SESSION['User']['accessToken'] = $accessToken;
        $_SESSION['User']['accountId'] = $accountId;
//        $selfUrl = esc_url( apply_filters( 'the_permalink', get_permalink() ) );
//        wp_redirect($selfUrl);
    }

    public static function logauthWG() {
        unset($_SESSION['User']);
    }

    public static function addCache($name, $result) {
        if (!apc_fetch($name)) {
            apc_add($name, $result);
            $data = json_decode($result);
            echo 'кешировано';
        } else {
            $data = json_decode(apc_fetch($name));
        }
        return $data;
    }

    public function clearCache($type = '') {
        apc_clear_cache($type);
    }

}
