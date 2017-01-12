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
        $this->db->exec("SET NAMES utf8");
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
        return ['getCountAllTotal'=>$this->getCountAllProcessor($model)->getCountAllTotal,'result'=>$prepare->fetchAll(\PDO::FETCH_OBJ)];

    }

    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getCountAllProcessor($model){
        $getCountAll=$this->db->prepare($this->sqlBuilderDefinition($model,1));
        $getCountAll->execute($model['execute']);
        $getCountAll=$getCountAll->fetch(\PDO::FETCH_OBJ);
        return $getCountAll;
    }

    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function sqlBuilderDefinition($model,$getCountAll=null){
        if($getCountAll!==null){
            $model['select']='COUNT(id) as getCountAllTotal';
            $getPaginateProcessor=$this->getPaginateProcessor($model,false);
        }
        else{
            $getPaginateProcessor=$this->getPaginateProcessor($model);
        }
        //return select definition
        return "SELECT ".$model['select']." FROM ".$model['model']->table." ".$model['where']." ".$this->getOrderByProcessor($model)." ".$getPaginateProcessor."";
    }

    /**
     * Represents a getPaginateProcessor class.
     *
     * main call
     * return type array
     */

    public function getPaginateProcessor($model,$status=true){

        if($status){
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

        return '';

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


    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getInsertQueryFormatter($data,$model){
        $dataKeyValues=[];
        $dataPrepareValues=[];
        $dataExecuteValues=[];

        if(count($data)==0){
            $input=$this->request->input();
            $data=(count($input)) ? $input : $data;
        }


        if(array_key_exists("_token",$data)){
            $data=\app::arrayDelete($data,['_token']);
        }

        //insert condition according to model
        if(property_exists($model,"insertConditions") && $model->insertConditions['status']){
            foreach($data as $key=>$value){
                //wanted fields
                if(count($model->insertConditions['wantedFields']) && !in_array($key,$model->insertConditions['wantedFields'])){
                    return [
                        'error'=>true,
                        'message'=>'there is forbidden data in post sent'
                    ];
                }
                //except fields
                if(count($model->insertConditions['exceptFields']) && in_array($key,$model->insertConditions['exceptFields'])){
                    return [
                        'error'=>true,
                        'message'=>'there is forbidden data in post sent'
                    ];
                }
            }

            //except fields
            $obligatoryFields=$model->insertConditions['obligatoryFields'];
            if(count($obligatoryFields)){
                foreach($obligatoryFields as $value){
                    if(!array_key_exists($value,$data)){
                        return [
                            'error'=>true,
                            'message'=>'there is no obligatory data in post sent'
                        ];
                    }
                }
            }

            //queue fields
            $queueFields=$model->insertConditions['queueFields'];
            if(count($queueFields)) {
                foreach ($queueFields as $key=>$value) {
                    $data[$key]=$value;
                }
            }

            //queue createdAt AND updatedAt fields
            if(property_exists($model,"createdAndUpdatedFields") && count($model->createdAndUpdatedFields)) {
                $time=time();
                foreach ($model->createdAndUpdatedFields as $key=>$value) {
                    $data[$value]=$time;
                }
            }
        }


        //last data
        foreach($data as $key=>$value){
            if($key!=="id"){
                $dataKeyValues[]=$key;
            }

            $dataPrepareValues[]='?';
            $dataExecuteValues[]=$value;
        }


        try {
            $query=$this->db->prepare("INSERT INTO ".$model->table." (".implode(",",$dataKeyValues).") VALUES (".implode(",",$dataPrepareValues).")");
            if($query->execute($dataExecuteValues)){
                return ['post'=>['status'=>true]];
            }
        }
        catch(\Exception $e){
            if(\app::environment()=="local"){
                return [
                    'error'=>true,
                    'message'=>$e->getMessage(),
                    'trace'=>$e->getTrace()
                ];
            }
            else{
                return [
                    'error'=>true,
                    'message'=>'error occured'
                ];
            }
        }



    }



    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    private function getModelInsertedConditions($data,$model){


    }

}