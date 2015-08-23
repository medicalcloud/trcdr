<?php namespace trcdr;
// 要するに、外部ネットにアクセスするためのクラス。
// もともと、Serversという名前だった。
class OuterWeb {
    public function getFile($url){
        $context = stream_context_create(array(
            'http' => array('ignore_errors' => false
            ,'timeout' => 2
            )
        ));
        
        $file = file_get_contents($url, false, $context);
        if(empty($file)){
            throw new ExternalServerException('Url"'.$url.'" server does not work');
        }
        
        preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
        $status_code = $matches[1];

        if($status_code === '200'){
            return $file;
        }else{
            throw new ExternalServerException('Url"'.$url.'" return code"'.$status_code.'"');
        }
        // $proxy = array(
        //     'http' => array(
        //         'proxy' => 'http://pcproxy.itakura.toyo.ac.jp:8080/',
        //         'request_fulluri' => true,
        //     ),
        // );
        // $proxy_content = stream_context_create($proxy);
        // return file_get_contents($url, false, $proxy_content);
 
    }

    public function getTitle($url){
        
        $html = $this->getFile($url);
        preg_match('/<title>(.+)<\/title>/',$html,$matches);
        $title = $matches[1];
        return $title;
    }
}

class ExternalServerException extends Exception{
}
