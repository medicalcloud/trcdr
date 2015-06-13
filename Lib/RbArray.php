<?php
/*
$arr = new RbArray(array("one" => 1, "two" => 2, "three" => 3));
$arr->eachPair(function($key, $val) { echo "$key: is $val\n"; });

$rr = new RbRange(1, 10);
$rr->each(function($i) { echo $i*$i."\n"; });
 
 */

class RbArray implements ArrayAccess{
    protected $array;

    public function __construct(array $a){
        $this->array = $a;
    }

    public function toArray(){
        return $this->array;
    }

    public function offsetExists($offset){
        return $this->keyExist;
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

    public function eachPair($body){
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $iter->yield($key, $value);
        }
        return $this;
    }

    public function eachValue($body){
        $iter = new RbIterator($body);
        foreach($this->array as $value){
            $iter->yield($value);
        }
        return $this;
    }

    public function eachKey($body){
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $iter->yield($key);
        }
        return $this;
    }

    public function mapPairToPair($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $key_and_value = $iter->yield($key, $value);
            $newArray[$key_and_value[0]] = $key_and_value[1];
        }
        return new RbArray($newArray);
    }

    public function mapPairToValue($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $newvalue = $iter->yield($key, $value);
            $newArray[] = $newvalue;
        }
        return new RbArray($newArray);
    }

    public function cathegorizeByValue($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $value){
            $newkey = $iter->yield($value);
            if(is_null($newArray[$newkey])){
                $newArray[$newkey] = new RbArray(array($value));
            }else{
                $newArray[$newkey]->addValue($value);
            }
        }
        return new RbArray($newArray);
    }

    public function cathegorizeByPair($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            $newkey = $iter->yield($key, $value);
            if(is_null($newArray[$newkey])){
                $newArray[$newkey] = new RbArray(array($value));
            }else{
                $newArray[$newkey]->addValue($value);
            }
        }
        return new RbArray($newArray);
    }

    public function selectByPair($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $key => $value){
            if($iter->yield($key, $value)){
                $newArray[$key] = $value;
            }
        }
        return new RbArray($newArray);
    }

    public function selectByValue($body){
        $newArray = [];
        $iter = new RbIterator($body);
        foreach($this->array as $value){
            if($iter->yield($value)){
                $newArray[] = $value;
            }
        }
        return new RbArray($newArray);
    }

    public function inject($init, $body){ // use like ruby 
        $iter = new RbIterator($body);
        $mem = $init;
        foreach($this->array as $value){
            $mem = $iter->yield($mem, $value);
        }
        return $mem;
    }

    protected function toStr($key){
        if(isobject($key)){
            return $key->__toString();
        }elseif(isstring($key)){
            return $key;
        }else{
            return null;
        }
    }

    public function addPair($key, $value){
        $this->toStr($key);
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
        $key = $this->toStr($key);
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
        $key = $this->toStr($key);
        unset($this->array[$key]);
        return $this;
    }

    public function keyExist($key){
        $key = $this->toStr($key);
        return array_key_exist($key, $this->array);
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

    public function yield(){
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
