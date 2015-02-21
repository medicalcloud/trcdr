<?php
class Mailer {
    public function __construct(){
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
    }

    public function mail($to, $title, $message, $from){
        $result = mb_send_mail($to, $title, $message, 'From: '.$from);
        return $result; #if result of sending mail is success, return true
                        #if failed, return false
    }
}
