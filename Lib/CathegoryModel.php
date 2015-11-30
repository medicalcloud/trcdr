<?php namespace trcdr;
Pathes::loadLib('Model');
class CathegoryModel extends Model {
    protected static $tableName = 'cathegory';
    protected static $columnNames = array('code', 'jp', 'en');

    public static function findByName($name, $lang = 'jp'){
        switch($lang) {
        case 'jp':
            return static::findOneByParam('jp', $name);
            break;
        default:
            return static::findOneByParam('en', $name);
            break;
        }
    }

    public static function findByCode($code){
        return static::findOneByParam('code', $code);
    }

    public static function findAllUnder($codepart){
        return static::findAll('code LIKE "'.$codepart.'%"');
    }

/*    public static function createFromArray($array){
        foreach($array as $cathegory_data){
            $code = $cathegory_data['code'];
            if(static::findByCode($code)){
                #do nothing
            }else{
                static::create($cathegory_data);
            }
        }
    }
 */

    // すこしリファクタリング、あとで動作確認
    public function shortName($lang = 'jp'){
        switch($lang) {
        case 'jp':
            $name = $this->jp;
            break;
        default:
            $name = $this->en;
            break;
        }
        $shortName = mb_substr($name, mb_strpos($name, '/') + 1);
        return $shortName;
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
