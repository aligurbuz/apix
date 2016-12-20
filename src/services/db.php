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
use src\services\httprequest as request;

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
    private static $modelscope=null;
    private static $page=null;
    private static $order=null;
    private static $request=null;


    public function __construct(){

        self::$request=new request();
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
     * query where scope.
     *
     * @return pdo class
     */
    public static function scope($scope=null){

        if($scope!==null){
           self::$modelscope=$scope;
        }

        return new static;

    }


    /**
     * query where.
     *
     * @return pdo class
     */
    public static function where($field=null,$operator=null,$value=null){

        //instance check
        if(self::$_instance==null){
            self::$_instance=new self();
        }

        //if the field value is callback value
        //a callback function is run
        if(is_callable($field)){
            call_user_func_array($field,self::$where);

        }
        else{
            //where criteria coming with all values
            //where nested true
            if($field!==null AND $operator!==null AND $value!==null){
                self::$where['field'][]=$field;
                self::$where['operator'][]=$operator;
                self::$where['value'][]=$value;

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
     * query paginate.
     *
     * @return pdo class
     */
    public static function paginate($page=null){

        if($page!==null){

            self::$page=$page;
        }
        return self::get();

    }

    /**
     * query order by.
     *
     * @return pdo class
     */
    public static function orderBy($key=null,$order=null){

        if($key!==null){

            if($order==null){
                $order='desc';
            }

            self::$order=['key'=>$key,'order'=>$order];
        }
        return new static;

    }


    /**
     * query get.
     *
     * @return pdo class
     */
    public static function get(){

        $model=new static;
        //get primary key
        self::$primarykey_static=(property_exists($model,"primaryKey")) ? $model->primaryKey : 'id';

        $execute=[];
        $where='';

        //select filter
        $select=self::getSelectOperation();
        //get select hidden
        if(property_exists($model,"selectHidden")){
            $query=self::$db->prepare("SHOW COLUMNS FROM ".$model->table."");
            $query->execute();
            $columns=$query->fetchAll(\PDO::FETCH_OBJ);
            $select=self::getSelectOperation($columns);
        }

        //where filter
        $whereOperation=self::getWhereOperation();
        if(count($whereOperation)){
            $where.=self::getWhereOperation()['where'];
            $execute=self::getWhereOperation()['execute'];
        }

        //ofset filter
        $offsetOperation=self::getOffsetOperation();
        $offset='';
        if(count($offsetOperation)){
            $offset.='LIMIT ';
            $offset.=self::getOffsetOperation()['offset'];
            $offset.=',';
            $offset.=self::getOffsetOperation()['limit'];
        }

        //get Orderby
        $order=self::getOrderByOperation();

        $query=self::$db->prepare("select ".$select." from ".$model->table." ".$where." ".$order." ".$offset."");
        $query->execute($execute);
        return $query->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * query get order by operation.
     *
     * @return pdo class
     */
    public static  function getOrderByOperation(){

        $model=new static;

        if(self::$order!==null && is_array(self::$order)){
            $order='';
            $order.='ORDER BY '.self::$order['key'].' '.self::$order['order'].'';
        }
        else{
            $order='';
            if(property_exists($model,"orderBy")){
                if(array_key_exists("auto",$model->orderBy)){
                    foreach($model->orderBy['auto'] as $order_key=>$order_value){
                        $order.='ORDER BY '.$order_key.' '.$order_value.'';
                    }
                }
            }
        }


        return $order;
    }

    /**
     * query get order by operation.
     *
     * @return pdo class
     */
    public static  function getSelectOperation($columns=null){
        //select filter
        $model=new static;
        $select=(is_array(self::$select)) ? implode(",",self::$select) : self::$select;
        if($columns==null){
            if(property_exists($model,"selectHiddenPasswordField")){
                $selectExclude=[];
                foreach ($model->selectHiddenPasswordField as $exclude) {
                    if(self::$select=="*" OR in_array($exclude,self::$select)){
                        $selectExclude[]=" '***' as ".$exclude."";
                    }
                }
                if(count($selectExclude)){
                    $select=''.$select.' ,'.implode(",",$selectExclude).'';
                }
            }
        }
        else{
            $collist=[];
            if(property_exists($model,"selectHidden")){
                if(is_array(self::$select) && count(self::$select)){
                    $columns=self::$select;
                    foreach($columns as $col_key=>$col_value){
                        if(!in_array($col_value,$model->selectHidden)){
                            $collist[]=$col_value;
                        }
                    }
                }
                else{
                    foreach($columns as $col){
                        if(!in_array($col->Field,$model->selectHidden)){
                            $collist[]=$col->Field;
                        }
                    }
                }

                $select=implode(",",$collist);
            }
        }
        return $select;

    }

    /**
     * query get where operation.
     *
     * @return pdo class
     */

    private static function getWhereOperation(){

        $list=[];
        $model=new static;

        //model scope
        self::getScopeOperation();

        //find method
        if(self::$find!==null){
            $list['where']='WHERE '.self::$primarykey_static.'=:'.self::$primarykey_static.'';
            $list['execute']=array(':'.self::$primarykey_static.''=>self::$find);

        }
        else{
            if(count(self::$where)){

                $fieldPrepareArray=[];
                foreach(self::$where['field'] as $field_key=>$field_value){
                    $fieldPrepareArray[]=''.$field_value.''.self::$where['operator'][$field_key].':'.$field_value.'';
                    $fieldPrepareArrayExecute[':'.$field_value.'']=self::$where['value'][$field_key];
                }
                $list['where']='WHERE '.implode(" AND ",$fieldPrepareArray);
                $list['execute']=$fieldPrepareArrayExecute;
            }

        }

        return $list;
    }


    /**
     * query get offset operation.
     *
     * @return pdo class
     */

    private static function getOffsetOperation(){

        $list=[];
        $model=new static;
        $request=self::$request;

        if(self::$page==null && property_exists($model,"paginator")){
            if(array_key_exists("auto",$model->paginator)){
                self::$page=$model->paginator['auto'];
            }
        }

        if(self::$page!==null){

            $offset=0;
            $getQueryString=$request->getQueryString();
            if(count($getQueryString)){
                if(array_key_exists("page",$getQueryString)){
                    $offset=$getQueryString['page']-1;
                    $offset=$offset*self::$page;
                }
            }
            $list['offset']=$offset;
            $list['limit']=self::$page;
        }

        return $list;

    }


    /**
     * query scope where operation.
     *
     * @return pdo class
     */

    private static function getScopeOperation(){

        //get model
        $model=new static;
        //get scope
        $scope=[];
        if(self::$modelscope!==null){
            $scope=$model->modelScope(self::$modelscope);
            if(is_array(self::$modelscope)){
                $modelScopeJoin=[];
                foreach (self::$modelscope as $modelscope_key=>$modelscope_value) {
                    foreach($model->modelScope($modelscope_value) as $mvkey=>$mvvalue){
                        $scope[$mvkey]=$mvvalue;
                    }
                }
            }
        }
        else{
            if(property_exists($model,"scope")){
                if(array_key_exists("auto",$model->scope)){
                    if(!is_array($model->scope['auto'])){
                        $scope=$model->modelScope($model->scope['auto']);
                    }
                    else{
                        $modelScopeJoin=[];
                        foreach ($model->scope['auto'] as $modelscope_key=>$modelscope_value) {
                            foreach($model->modelScope($modelscope_value) as $mvkey=>$mvvalue){
                                $scope[$mvkey]=$mvvalue;
                            }
                        }
                    }

                }

            }
        }

        //get scope where
        foreach($scope as $scope_key=>$scope_value){
            self::$where['field'][]=$scope_key;
            self::$where['operator'][]="=";
            self::$where['value'][]=$scope_value;
        }

        return self::$where;
    }
}
