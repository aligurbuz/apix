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
    private static $table=null;
    private static $select="*";
    private static $find=null;


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
     * database table.
     *
     * @return pdo class
     */
    public static function table($table=null,$find=null){

        if(self::$_instance==null){
            self::$_instance=new self();
        }

        if($table!==null){
            self::$table=$table;
        }

        if($find!==null){

            self::$find=$find;
            return self::get();
        }

        return new static;

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

        $execute=[];
        $where='';

        //select filter
        $select=(is_array(self::$select)) ? implode(",",self::$select) : self::$select;

        //where filter
        if(self::$find!==null){
            $where.='WHERE id=:id';
            $execute[':id']=self::$find;

        }


        $query=self::$db->prepare("select ".$select." from ".self::$table." ".$where."");
        $query->execute($execute);
        return $query->fetchAll(\PDO::FETCH_OBJ);

    }


}
