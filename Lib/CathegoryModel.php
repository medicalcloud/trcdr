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

    public static function create_from_array(){
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

    public static function default_data_array(){
        $default_data_array = array(
            array('code' => 'vac/mr', 'jp' => 'MR', 'en' => 'MR')
            ,array('code' => 'vac/mumps', 'jp' => 'おたふくかぜ', 'en' => 'mumps')
        );
        return $default_data_array;
    }
}
