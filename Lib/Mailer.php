<?php namespace trcdr;
class Mailer {
    private static $from;

    public static function setFrom($from){
        static::$from = $from;
    }

    public function __construct(){
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
    }

    public function mail($to, $title, $message){
        $result = mb_send_mail($to, $title, $message, 'From: '.static::$from);
        #if result of sending mail is failed, return false
        if(!$result){
            throw new TMailException('send mail failed');
        }
    }
}

class TMailException extends \Exception{
}
