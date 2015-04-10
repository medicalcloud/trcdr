<?php
Pathes::loadLib('Model');
class CathegoryModel extends Model {
    protected static $tableName = 'cathegory';
    protected static $columnNames = array('code', 'jp', 'en');

    public static function findByJp($jp){
        return static::findOneByParam('jp', $jp);
    }

    public static function findByEn($en){
        return static::findOneByParam('en', $en);
    }

    public static function findByCode($code){
        return static::findOneByParam('code', $code);
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
}
