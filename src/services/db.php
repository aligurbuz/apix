<?php
/*
 * This file is client and browser info of the fussy service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;

/**
 * Represents a redis class.
 *
 * main call
 * return type string
 */

class db {

    private static $_instance=null;
    private $driver;
    private $host;
    private $database;
    private $user;
    private $password;
    private static $db;
    private static $select="*";
    private static $find=null;
    private static $where=[];

    private static $primarykey_static=null;


    public function __construct(){

        $config="\\src\\app\\".app."\\".version."\\config\\database";
        $configdb=$config::dbsettings();

        $this->driver=$configdb['driver'];
        $this->host=$configdb['host'];
        $this->database=$configdb['database'];
        $this->user=$configdb['user'];
        $this->password=$configdb['password'];

        self::$db = new \PDO(''.$this->driver.':host='.$this->host.';dbname='.$this->database.'', $this->user,$this->password);
        self::$db->exec("SET CHARACTER SET utf8");
        self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }


    /**
     * query select.
     *
     * @return pdo class
     */
    public static function select($select=null){

        if($select!==null){
            if(is_array($select)){
                self::$select=$select;
            }
        }

        return new static;

    }


    /**
     * query where.
     *
     * @return pdo class
     */
    public static function where($field,$operator,$value){

        if(self::$_instance==null){
            self::$_instance=new self();
        }

        self::$where['field'][]=$field;
        self::$where['operator'][]=$operator;
        self::$where['value'][]=$value;


        return new static;

    }



    /**
     * query find.
     *
     * @return pdo class
     */
    public static function find($find=null,$select=null){

        if($find!==null){

            self::$find=$find;
        }

        if($select!==null){
            if(is_array($select)){
                self::$select=$select;
            }
        }

        return self::get();

    }


    /**
     * query get.
     *
     * @return pdo class
     */
    public static function get(){

        //dd(self::$where);
        $model=new static;
        //get primary key
        self::$primarykey_static=(property_exists($model,"primaryKey")) ? $model->primaryKey : 'id';

        $execute=[];
        $where='';

        //select filter
        $select=(is_array(self::$select)) ? implode(",",self::$select) : self::$select;

        //where filter
        $whereOperation=self::getWhereOperation();
        if(count($whereOperation)){
            $where.=self::getWhereOperation()['where'];
            $execute=self::getWhereOperation()['execute'];
        }

        $query=self::$db->prepare("select ".$select." from ".$model->table." ".$where."");
        $query->execute($execute);
        return $query->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * query get where operation.
     *
     * @return pdo class
     */

    private static function getWhereOperation(){

        $list=[];
        if(self::$find!==null){
            $list['where']='WHERE '.self::$primarykey_static.'=:'.self::$primarykey_static.'';
            $list['execute']=array(':'.self::$primarykey_static.''=>self::$find);

        }

        return $list;
    }


}
