<?php
/*
 * This file is main part of the sudb.
 *
 * model is called for model file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\packages\providers\sudb\src;
use src\services\httprequest as request;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class querySqlFormatter {


    private static $instance=null;
    private $driver;
    private $host;
    private $database;
    private $user;
    private $password;
    private $db=null;
    private $request;

    public function __construct(){

        $this->request=new request();
        $config="\\src\\app\\".app."\\".version."\\config\\database";
        $configdb=$config::dbsettings();

        $this->driver=$configdb['driver'];
        $this->host=$configdb['host'];
        $this->database=$configdb['database'];
        $this->user=$configdb['user'];
        $this->password=$configdb['password'];

        /** @var TYPE_NAME $this */
        try {

            if(self::$instance===null){
                $this->db = new \PDO(''.$this->driver.':host='.$this->host.';dbname='.$this->database.'', $this->user,$this->password);
                $this->db->exec("SET NAMES utf8");
                $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES,false);
                //$this->db->setAttribute(\PDO::ATTR_PERSISTENT,true);

                self::$instance=$this->db;
            }

            $this->db=self::$instance;
        }
        catch (\PDOException $e) {
            if(environment()=="local"){
                $connectionError=[
                    'status'=>false,
                    'result'=>[
                        'error'=>true,
                        'code'=>$e->getCode(),
                        'message'=>'Database Connection Error',
                        'trace'=>$e->getTrace()
                    ]

                ];
                echo json_encode($connectionError);
            }
            else{
                $connectionError=[
                    'status'=>false,
                    'result'=>[
                        'error'=>true,
                        'message'=>'Error occured'
                    ]

                ];
                echo json_encode($connectionError);
            }

            exit();
        }

    }


    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getSqlPrepareFormatter($model){

        if(in_array(false,$model['bool'])){
            return [
                'getCountAllTotal'=>0,
                'paginator'=>$this->getModelOffsetPaginator($model),
                'currentPage'=>$this->getPaginatorUrlPage(),
                'result'=>[],
                'columns'=>$this->getModelTableShowColumns($model['model']->table),
                'fields'=>$this->getResultFields([])
            ];
        }

        try {

            $prepare=$this->db->prepare($this->sqlBuilderDefinition($model));
            $prepare->execute($model['execute']);
            $result=$prepare->fetchAll(\PDO::FETCH_OBJ);
            return [
                'getCountAllTotal'=>$this->getCountAllProcessor($model),
                'paginator'=>$this->getModelOffsetPaginator($model),
                'currentPage'=>$this->getPaginatorUrlPage(),
                'result'=>$result,
                'columns'=>$this->getModelTableShowColumns($model['model']->table),
                'fields'=>$this->getResultFields($result)
            ];
        }
        catch(\Exception $e){
            return [
                'result'=>[
                    'error'=>true,
                    'code'=>$e->getCode(),
                    'message'=>'sql logic error',
                    'trace'=>$e->getTrace()
                ]

            ];
        }


    }

    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getCountAllProcessor($model){

        //dd($this->sqlBuilderDefinition($model,1));
        $getCountAll=$this->db->prepare($this->sqlBuilderDefinition($model,1));
        $getCountAll->execute($model['execute']);
        if($model['groupBy']!==null){
            $getCountAll=$getCountAll->rowCount(\PDO::FETCH_OBJ);
            return $getCountAll;
        }
        else{
            $getCountAll=$getCountAll->fetch(\PDO::FETCH_OBJ);
            return $getCountAll->getCountAllTotal;
        }

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

        if($model['groupBy']!==null){
            $model['select']=''.$model['groupBy'].',count(*) as groupBy'.$model['groupBy'].'Total';
        }
        //return select definition
        return "SELECT ".$model['select']." FROM ".$model['model']->table." ".$model['where']." ".$this->getGroupByProcessor($model)." ".$this->getOrderByProcessor($model)." ".$getPaginateProcessor."";
    }

    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getPaginatorUrlPage(){
        if(array_key_exists("page",$this->request->getQueryString())){
            $page=$this->request->getQueryString()['page'];
        }
        else{
            $page=1;
        }

        return $page;
    }


    /**
     * Represents a group by processor class.
     *
     * main call
     * return type array
     */

    public function getGroupByProcessor($model){
        $groupBy='';

        if($model['groupBy']!==null){
            $groupBy.='GROUP BY '.$model['groupBy'].' ';
        }

        return $groupBy;
    }


    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getModelOffsetPaginator($model){
        $paginatorDefinitive=0;
        if(property_exists($model['model'],"paginator")) {
            if (array_key_exists("auto", $model['model']->paginator)) {
                $paginatorDefinitive = $model['model']->paginator['auto'];
            }
        }

        if($model['paginate']>0){
            $paginatorDefinitive=$model['paginate'];
        }

        return $paginatorDefinitive;
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
                if($columns[$key]->Type=="tinyint(1)"){
                    $columnsList['type'][$columns[$key]->Field]="bool";
                }
                else{
                    $columnsList['type'][$columns[$key]->Field]=$columns[$key]->Type;
                }

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
        $bool=$model['bool'];
        $transaction=$model['transaction'];
        $transactionName=$model['transactionName'];
        $model=$model['model'];
        if($bool===false){
            return [
                'error'=>true,
                'code'=>203,
                'message'=>'bool criteria is false'
            ];
        }
        $dataKeyValues=[];
        $dataPrepareValues=[];
        $dataExecuteValues=[];

        if(count($data)==0){
            $input=$this->request->input();
            $data=(count($input)) ? $input : $data;
        }


        if(array_key_exists("_token",$data)){
            $data=self::arrayDelete($data,['_token']);
        }

        //insert condition according to model
        if(property_exists($model,"insertConditions") && $model->insertConditions['status']){
            foreach($data as $key=>$value){
                //wanted fields
                if(count($model->insertConditions['wantedFields']) && !in_array($key,$model->insertConditions['wantedFields'])){
                    return [
                        'error'=>true,
                        'code'=>203,
                        'message'=>'there is forbidden data in post sent'
                    ];
                }
                //except fields
                if(count($model->insertConditions['exceptFields']) && in_array($key,$model->insertConditions['exceptFields'])){
                    return [
                        'error'=>true,
                        'code'=>203,
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
                            'code'=>203,
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
        }


        //queue createdAt AND updatedAt fields
        if(property_exists($model,"createdAndUpdatedFields") && count($model->createdAndUpdatedFields)) {
            $time=time();
            foreach ($model->createdAndUpdatedFields as $key=>$value) {
                $data[$value]=$time;
            }
        }


        //last data
        foreach($data as $key=>$value){
            if(strlen(trim($value))==0){
                if(environment()=="local"){
                    return [
                        'error'=>true,
                        'message'=>'empty data would not been sent'
                    ];
                }
                else{
                    return [
                        'error'=>true,
                        'message'=>'error occured'
                    ];
                }
            }
            if($key!=="id"){
                $dataKeyValues[]=$key;
            }

            $dataPrepareValues[]='?';
            $fieldMethod='field'.ucfirst($key);
            if(method_exists($model,$fieldMethod)){
                $dataExecuteValues[]=$model->$fieldMethod();
            }
            else{
                $dataExecuteValues[]=$value;
            }

        }

        if($transaction){
            $transactionList['create']['transactionName'][]=$transactionName;
            $transactionList['create']['table'][]=$model->table;
            $transactionList['create']['field'][]=implode(",",$dataKeyValues);
            $transactionList['create']['value'][]=implode(",",$dataPrepareValues);
            $transactionList['create']['execute'][]=$dataExecuteValues;

            return $transactionList;

        }

        try {

            $query=$this->db->prepare("INSERT INTO ".$model->table." (".implode(",",$dataKeyValues).") VALUES (".implode(",",$dataPrepareValues).")");
            if($query->execute($dataExecuteValues)){
                return ['lastInsertId'=>$this->db->lastInsertId(),'status'=>true];
            }
        }
        catch(\Exception $e){
            if(environment()=="local"){
                return [
                    'error'=>true,
                    'code'=>$e->getCode(),
                    'message'=>$e->getMessage(),
                    'trace'=>$e->getTrace()
                ];
            }
            else{
                return [
                    'error'=>true,
                    'code'=>$e->getCode(),
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

    public function getUpdateQueryFormatter($data,$model){

        if($model['bool']===false){
            return [
                'error'=>true,
                'code'=>203,
                'message'=>'bool criteria is false'
            ];
        }

        if(count($data)==0){
            $input=$this->request->input();
            $data=(count($input)) ? $input : $data;
        }


        if(array_key_exists("_token",$data)){
            $data=self::arrayDelete($data,['_token']);
        }

        //update condition according to model
        if(property_exists($model['model'],"updateConditions") && $model['model']->updateConditions['status']){
            foreach($data as $key=>$value){
                //wanted fields
                if(count($model['model']->updateConditions['wantedFields']) && !in_array($key,$model['model']->updateConditions['wantedFields'])){
                    return [
                        'error'=>true,
                        'code'=>203,
                        'message'=>'there is forbidden data in post sent'
                    ];
                }
                //except fields
                if(count($model['model']->updateConditions['exceptFields']) && in_array($key,$model['model']->updateConditions['exceptFields'])){
                    return [
                        'error'=>true,
                        'code'=>203,
                        'message'=>'there is forbidden data in post sent'
                    ];
                }
            }

            //except fields
            $obligatoryFields=$model['model']->updateConditions['obligatoryFields'];
            if(count($obligatoryFields)){
                foreach($obligatoryFields as $value){
                    if(!array_key_exists($value,$data)){
                        return [
                            'error'=>true,
                            'code'=>203,
                            'message'=>'there is no obligatory data in post sent'
                        ];
                    }
                }
            }

            //queue fields
            $queueFields=$model['model']->updateConditions['queueFields'];
            if(count($queueFields)) {
                foreach ($queueFields as $key=>$value) {
                    $data[$key]=$value;
                }
            }


        }


        //queue createdAt AND updatedAt fields
        if(property_exists($model['model'],"createdAndUpdatedFields") && count($model['model']->createdAndUpdatedFields)) {
            $time=time();
            foreach ($model['model']->createdAndUpdatedFields as $key=>$value) {
                if($key!=="created_at"){
                    $data[$value]=$time;
                }

            }
        }



        $set=[];
        if(count($data)){
            foreach($data as $key=>$value){
                if($key!=="id"){
                    $set[]=''.$key.'=:'.$key.'';
                    $model['execute'][':'.$key]=$value;
                }

            }


            try {
                $query=$this->db->prepare("UPDATE ".$model['model']->table." SET  ".implode(",",$set)." ".$model['where']."");
                if($query->execute($model['execute'])){
                    return true;
                }
            }
            catch(\Exception $e){
                if(environment()=="local"){
                    return [
                        'error'=>true,
                        'code'=>$e->getCode(),
                        'message'=>$e->getMessage(),
                        'trace'=>$e->getTrace()
                    ];
                }
                else{
                    return [
                        'error'=>true,
                        'code'=>$e->getCode(),
                        'message'=>'error occured'
                    ];
                }
            }
        }

        return [
            'error'=>true,
            'message'=>'there is no postdata for update process'
        ];






    }


    /**
     * Represents a getSqlPrepareFormatter class.
     *
     * main call
     * return type array
     */

    public function getDeleteQueryFormatter($data,$model){

        try {
            $query=$this->db->prepare("DELETE FROM ".$model['model']->table." ".$model['where']."");
            if($query->execute($model['execute'])){
                return ['post'=>['status'=>true]];
            }
        }
        catch(\Exception $e){
            if(environment()=="local"){
                return [
                    'error'=>true,
                    'code'=>$e->getCode(),
                    'message'=>$e->getMessage(),
                    'trace'=>$e->getTrace()
                ];
            }
            else{
                return [
                    'error'=>true,
                    'code'=>$e->getCode(),
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

    private function getResultFields($data){
        foreach($data as $key=>$value){
            return json_decode(json_encode($data[$key]),1);
        }
    }


    /**
     * response arraydelete.
     * definition collection usefull
     * outputs array delete as key .
     *
     * @param string
     * @return response array delete runner
     */
    private static function arrayDelete($data,$delete){

        $list=[];
        foreach($data as $key=>$value){
            if(!in_array($key,$delete)){
                $list[$key]=$value;
            }
        }

        return $list;
    }



    /**
     * response transaction.
     * definition transaction database
     * outputs queries transaction as bool .
     *
     * @param string
     * @return response transaction database runner
     */
    public function getTransactionProcess($queries=null){
        $this->db->beginTransaction();
        try {
            $list=[];
            foreach($queries as $key=>$value){
                foreach($queries[$key]['create']['table'] as $t=>$tt){
                    $query=$this->db->prepare("INSERT INTO ".$tt." (".$queries[$key]['create']['field'][$t].") VALUES (".$queries[$key]['create']['value'][$t].")");
                    foreach ($queries[$key]['create']['execute'][$t] as $execute_key=>$execute_val){
                        if(preg_match('@:id@is',$execute_val)){
                            $exparam=explode(":",$execute_val);
                            $queries[$key]['create']['execute'][$t][$execute_key]=$list[$exparam[0]]['id'];
                        }
                    }
                    $query->execute($queries[$key]['create']['execute'][$t]);
                    $list[$queries[$key]['create']['transactionName'][$t]]['id']=$this->db->lastInsertId();
                }
            }

            $this->db->commit();
            return true;
        }
        catch(\Exception $e){
            $this->db->rollBack();
            if(environment()=="local"){
                return [
                    'error'=>true,
                    'code'=>$e->getCode(),
                    'message'=>$e->getMessage(),
                    'trace'=>$e->getTrace()
                ];
            }
            else{
                return [
                    'error'=>true,
                    'code'=>$e->getCode(),
                    'message'=>'error occured'
                ];
            }
        }
    }




}