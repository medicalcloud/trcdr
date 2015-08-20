<?php

/*

Classes work like ruby standard library

$arr = new RbArray(array("one" => 1, "two" => 2, "three" => 3));
$arr->eachPair(function($key, $val) { echo "$key: is $val\n"; });

$rr = new RbRange(1, 10);
$rr->each(function($i) { echo $i*$i."\n"; });

$str = new RbStr('string');
 */

class RbArray implements ArrayAccess{
    protected $array;

    public function __construct(array $a){
        $this->array = $a;
    }

    public function toArray(){
        return $this->array;
    }

    // methods to work as array
    public function offsetExists($offset){
        return $this->keyExist($offset);
    }

    public function offsetGet($offset){
        return $this->get($offset);
    }

    public function offsetSet($offset, $value){
        $this->addPair($offset, $value);
    }

    public function offsetUnset($offset){
        $this->remove($offset);
    }

    // iterator methods
    public function eachPair($body){
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $iter->yieldBlock($key, $value);
        }
        return $this;
    }

    public function eachValue($body){
        $iter = new RbIterator($body);
        foreach($this->array as $value){
            $iter->yieldBlock($value);
        }
        return $this;
    }

    public function eachKey($body){
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $iter->yieldBlock($key);
        }
        return $this;
    }

    public function mapPairToPair($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $key_and_value = $iter->yieldBlock($key, $value);
            $newArray[$key_and_value[0]] = $key_and_value[1];
        }
        return new RbArray($newArray);
    }

    public function mapPairToValue($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $newvalue = $iter->yieldBlock($key, $value);
            $newArray[] = $newvalue;
        }
        return new RbArray($newArray);
    }

    public function cathegorizeByValue($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $value){
            $newkey = $iter->yieldBlock($value);
            if(isset($newArray[$newkey])){
                $newArray[$newkey]->addValue($value);
            }else{
                $newArray[$newkey] = new RbArray(array($value));
            }
        }
        return new RbArray($newArray);
    }

    public function cathegorizeByPair($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $newkey = $iter->yieldBlock($key, $value);
            if(isset($newArray[$newkey])){
                $newArray[$newkey]->addValue($value);
            }else{
                $newArray[$newkey] = new RbArray(array($value));
            }
        }
        return new RbArray($newArray);
    }

    public function selectByPair($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            if($iter->yieldBlock($key, $value)){
                $newArray[$key] = $value;
            }
        }
        return new RbArray($newArray);
    }

    public function selectByValue($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $value){
            if($iter->yieldBlock($value)){
                $newArray[] = $value;
            }
        }
        return new RbArray($newArray);
    }

    public function inject($init, $body){ // use like ruby 
        $iter = new RbIterator($body);
        $mem = $init;
        foreach($this->array as $value){
            $mem = $iter->yieldBlock($mem, $value);
        }
        return $mem;
    }

    protected function makeKeyableFrom($key){
        if(is_object($key)){
            if(method_exist($key, '__toString')){
                return $key->__toString();
            }else{
                return null;
            }
        }elseif(is_array($key)){
            return null;
        }else{
            return $key;
        }
    }

    public function addPair($key, $value){
        $this->makeKeyableFrom($key);
        if(is_null($key)){
            $this->array[] = $value;
        }else{
            $this->array[$key] = $value;
        }
        return $this;
    }

    public function addValue($value){
        $this->array[] = $value;
        return $this;
    }

    public function length(){
        return count($this->array);
    }

    public function isEmpty(){
        return empty($this->array);
    }

    public function merge($other){
        if($other instanceof RbArray){
            $other = $other->toArray();
        }
        return new RbArray(array_merge($this->toArray, $other));
    }

    public function copy(){
        $newarray = $this->array;
        return new RbArray($newarray);
    }

    public function get($key){
        $key = $this->makeKeyableFrom($key);
        if(isset($this->array[$key])){
            return $this->array[$key];
        }else{
            return null;
        }
    }

    public function set($key, $value){
        $this->addPair($key, $value);
        return $this;
    }

    public function remove($key){
        $key = $this->makeKeyableFrom($key);
        unset($this->array[$key]);
        return $this;
    }

    public function keyExist($key){
        $key = $this->makeKeyableFrom($key);
        return isset($this->array[$key]);
    }

    public function __toString(){
        return '['.join(',', $this->array).']';
    }

// array function wrapper
    public function sortByKey(){
        ksort($this->array);
        return $this;
    }
}

class RbIterator{
    protected $body;
    public function __construct($body){
        if(!is_callable($body)){
            throw new Exception('Iterator body should be a callable');
        }
        $this->body = $body;
    }

    public function yieldBlock(){
        $args = func_get_args();
        return call_user_func_array($this->body, $args);
    }
}

class RbRange{
    protected $from, $to;
    
    public function __construct($from, $to){
        $this->from = $from;
        $this->to = $to;
    }

    public function each($body){
        $iter = new RbIterator($body);
        for($i = $this->from; $i<=$this->to; $i++){
            $iter->yield($i);
        }
        return $this;
    }
}

class RbStr{
    protected $string;

    public function __construct($string){
        $this->string = $string;
    }

    public function toString(){
        return $string;
    }

    public function __toString(){
        return $string;
    }

    public function equal($compared){
        return StrMan::equal($this->string, $compared);
    }

    public function sub($start, $end){
        return StrMan::sub($this->string, $start, $end);
    }
}

class StrMan{
    public static function equal($str_a, $str_b){
        return $str_a === $str_b;
    }

    public static function sub($string, $start, $end){
        //return substring from $start to $end 
    }
}
