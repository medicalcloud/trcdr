<?php

class Intermezzo{
    private $speeches = [];

    public function __construct(){
    }

    public function addSpeech($actor, $words, $angle = '140', $distance = '20'){
        $this->speeches[] = new Speech($actor, $words, $angle, $distance);
        return $this;
    }

    public function play($libretto_id = 'libretto'){
        $code = '<ol id="'.$libretto_id.'" style="display: none;">';
        foreach($this->speeches as $speech){
            $code = $code.$speech->line();
        }
        $code = $code.'</ol>';
        $code = $code.$this->javascriptPlayerCode($libretto_id);
        echo $code;
        return $this;
    }

    private function javascriptPlayerCode($libretto_id){
        return '<script>$(function(){$("#'.$libretto_id.'").crumble();});</script>';
    }
}

class Speech{
    private $actor, $words, $angle, $distance;

    public function __construct($actor, $words, $angle, $distance){
        $this->actor = $actor;
        $this->words = $words;
        $this->angle = $angle;
        $this->distance = $distance;
    }

    public function line(){
        $line = '<li data-target="'.$this->actor
            .'" data-angle="'.$this->angle.'" data-option="distance:'.$this->distance.'">';
        foreach($this->words as $word){
            $line = $line.'<p>'.$word.'</p>';
        }
        $line = $line.'</li>';
        return $line;
    }
}
