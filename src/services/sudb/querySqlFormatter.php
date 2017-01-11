<?php
/*
 * This file is main part of the sudb.
 *
 * model is called for model file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services\sudb;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class querySqlFormatter {


    private $driver;
    private $host;
    private $database;
    private $user;
    private $password;
    private $db;

    public function __construct(){

        $config="\\src\\app\\".app."\\".version."\\config\\database";
        $configdb=$config::dbsettings();

        $this->driver=$configdb['driver'];
        $this->host=$configdb['host'];
        $this->database=$configdb['database'];
        $this->user=$configdb['user'];
        $this->password=$configdb['password'];

        $this->db = new \PDO(''.$this->driver.':host='.$this->host.';dbname='.$this->database.'', $this->user,$this->password);
        $this->db->exec("SET CHARACTER SET utf8");
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getSqlPrepareFormatter($model){
        $prepare=$this->db->prepare($this->sqlBuilderDefinition($model));
        $prepare->execute($model['execute']);
        return $prepare->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function sqlBuilderDefinition($model){
        return "SELECT ".$model['select']." FROM ".$model['model']->table." ".$model['where']."";
    }


    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getModelTableShowColumns($table){
        $showColumns=$this->db->prepare("SHOW COLUMNS FROM ".$table."");
        $showColumns->execute();
        return $this->getColumnsTable($showColumns->fetchAll(\PDO::FETCH_OBJ));

    }

    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    private function getColumnsTable($columns=null){
       if($columns!==null){
            $columnsList=[];
            foreach($columns as $key=>$value){
                $columnsList['field'][]=$columns[$key]->Field;
                $columnsList['type'][]=$columns[$key]->Type;
            }

           return $columnsList;
       }

    }

}