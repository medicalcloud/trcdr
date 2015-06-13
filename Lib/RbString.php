<?php

class RbString{
    private $string;

    public function __construct($string){
        $this->string = $string;
    }

    public function toString(){
        return $this->string;
    }
}
