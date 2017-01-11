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
use src\services\httprequest as request;

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
    private $request;

    public function __construct(request $request){

        $this->request=$request;
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
        return "SELECT ".$model['select']." FROM ".$model['model']->table." ".$model['where']." ".$this->getOrderByProcessor($model)." ".$this->getPaginateProcessor($model)."";
    }

    /**
     * Represents a getPaginateProcessor class.
     *
     * main call
     * return type array
     */

    public function getPaginateProcessor($model){

        $offset=0;
        if(property_exists($model['model'],"paginator")) {
            if (array_key_exists("auto", $model['model']->paginator)) {
                $offset = $model['model']->paginator['auto'];
            }
        }

        if($model['paginate']==0 && $offset==0){
            return '';
        }

        if(array_key_exists("page",$this->request->getQueryString())){
            $page=$this->request->getQueryString()['page']-1;
        }
        else{
            $page=0;
        }


        if($model['paginate']==0){

            $page=$page*$offset;

            return 'LIMIT '.$page.','.$offset.'';
        }
        else{
            $page=$page*$model['paginate'];
            return 'LIMIT '.$page.','.$model['paginate'].'';
        }
    }


    /**
     * Represents a getPaginateProcessor class.
     *
     * main call
     * return type array
     */

    public function getOrderByProcessor($model){

        if($model['orderBy']!==null && is_array($model['orderBy'])){
            $order='';
            $order.='ORDER BY '.$model['model']->table.'.'.$model['orderBy']['key'].' '.$model['orderBy']['order'].'';

        }
        else{
            $order='';
            if(property_exists($model['model'],"orderBy")){
                if(array_key_exists("auto",$model['model']->orderBy)){
                    foreach ($model['model']->orderBy['auto'] as $order_key => $order_value) {
                        $order .= 'ORDER BY '.$model['model']->table.'.' . $order_key . ' ' . $order_value . '';
                    }
                }
            }
        }

        return $order;
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