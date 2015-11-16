<?php namespace trcdr;
class URLManager {
    public function redirect($path){
        if(preg_match('/^(https?|ftp)(:\/\/)/', $path)){
            header ('Location: '.$path);
        }elseif(preg_match('/^\/'.Pathes::basePath().'/', $path)){  #start with /trcdr 
            #ここで、Pathes::basePath()をコールする変更を
            header ('Location: '.$path);
        }else{
            header ('Location: '.Pathes::buildUrl($path));
        }
        die();
    }
}
