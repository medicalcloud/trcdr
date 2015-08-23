<?php namespace trcdr;
Pathes::loadLib('Model');
class CathegoryModel extends Model {
    protected static $tableName = 'cathegory';
    protected static $columnNames = array('code', 'jp', 'en');

    public static function findByName($name, $lang = 'jp'){
        switch($lang) {
        case 'jp':
            return static::findOneByParam('jp', $jp);
            break;
        default:
            return static::findOneByParam('en', $en);
            break;
        }
    }

    public static function findByCode($code){
        return static::findOneByParam('code', $code);
    }

    public static function findAllUnder($codepart){
        return static::findAll('code LIKE "'.$codepart.'%"');
    }

    public static function createFromArray($array){
        $default_data_array = static::default_data_array();
        foreach($default_data_array as $cathegory_data){
            $code = $cathegory_data['code'];
            if(static::findByCode($code)){
                #do nothing
            }else{
                static::create($cathegory_data);
            }
        }
    }

    public function shortName($lang = 'jp'){
        switch($lang) {
        case 'jp':
            $names = explode('/', $this->jp);
            return end($names);
            break;
        default:
            $names = explode('/', $this->en);
            return end($names);
            break;
        }
    }

    public function fullName($lang = 'jp'){
        switch($lang) {
        case 'jp':
            return $this->jp;
            break;
        default:
            return $this->en;
            break;
        }
   }

    public function shortCode(){
        $names = explode('/', $this->code);
        return end($names);
    }

    public function fullCode(){
        return $this->code;
    }

    public function dir(){
        $pos = strrpos($this->code, '/');
        return substr($this->code, 0, $pos + 1);
    }

    public static function cathegorize($episodes){
        //convert array of episodes to array string(cathegory_code) -> array of episodes 
    }

    public function equal($other){
        if($other instanceOf CathegoryModel){
            return $other->code === $thie->code;
        }elseif(is_string($other)){
            return $other === $this->code;
        }
    }
}
