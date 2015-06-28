<?php

class Operetta{
    private $speeches = [];

    public function __construct(){
    }

    public function addSpeech($actor, $words, $angle = '140', $distance = '20'){
        $this->speeches[] = new Speech($actor, $word, $angle, $distance);
        return $this;
    }

    public function play($libretto_id = '#libretto'){
        $code = '<ol id="'.$libretto_id.'" style="display: none;">';
        foreach($speeches as $speech){
            $code += $speech->line();
        }
        $code += '</ol>';
        $code += $this->javascriptPlayerCode($libretto_id);
        echo $code;
        return $this;
    }

    private function javascriptPlayerCode($libretto_id){
        return '<script>$(function(){$("'.$libretto_id.'").crumble();});</script>';
    }
}

class Speech{
    private $actor, $words, $angle, $distance;

    public function __construct($actor, $words, $angle, $distance){
        $this->actor = $actor;
        $this->word = $words;
        $this->angle = $angle;
        $this->distance = $distqnce;
    }

    public function line(){
        $line = '<li data-target="'.$this->actor
            .'" data-angle="'.$this->angle.'" data-option="distance:'.$this->distance.'">';
        foreach($words as $word){
            $line += '<p>'.$word.'</p>';
        }
        $line += '<li>';
        return $line;
    }
}
