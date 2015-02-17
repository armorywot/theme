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
//        self::clearCache();
        $data = self::addCache('dataWargag', $result);
        
        if ($data->status == 'ok')
            $responce = $data->data;
        else
            $responce = false;
        
        return $responce;
    }

    public static function authWG($accessToken, $nickName, $accountId) {
        session_start();
        
        if(isset($_SESSION['User']))
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
