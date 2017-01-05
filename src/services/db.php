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
use src\app\mobi\v1\model\count;
use src\app\mobi\v1\model\user;
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
    private static $execute=[];

    private static $primarykey_static=null;
    private static $modelscope=null;
    private static $page=null;
    private static $order=null;
    private static $request=null;
    private static $toSql=null;
    private static $rand=null;
    private static $all=null;
    private static $callstatic_scope=[];
    private static $join=null;
    private static $joinType=null;
    private static $joinTypeField=null;
    private static $hasMany=null;
    private static $attach=null;
    private static $sum=null;
    private static $offset='';
    private static $joiner='';
    private static $whereIn=null;
    private static $whereNotIn=null;
    private static $orWhere=[];
    private static $whereColumn=[];
    private static $whereYear=[];


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


    public static function staticFlowCallback(){
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
     * query where In.
     *
     * @return pdo class
     */
    public static function whereIn($field=null,$data=array()){

        if($field!==null && count($data)){

            self::$whereIn['field']=$field;
            self::$whereIn['data']=$data;
        }

        return new static;

    }

    /**
     * query where Not In.
     *
     * @return pdo class
     */
    public static function whereNotIn($field=null,$data=array()){

        if($field!==null && count($data)){

            self::$whereNotIn['field']=$field;
            self::$whereNotIn['data']=$data;
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
            $getclass="\\".get_called_class();
            call_user_func_array($field,[$getclass::staticFlowCallback()]);

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
     * query where.
     *
     * @return pdo class
     */
    public static function whereColumn($field=null,$operator=null,$value=null){

        //instance check
        if(self::$_instance==null){
            self::$_instance=new self();
        }

        //if the field value is callback value
        //a callback function is run
        if(is_callable($field)){
            $getclass="\\".get_called_class();
            call_user_func_array($field,[$getclass::staticFlowCallback()]);

        }
        else{
            //where criteria coming with all values
            //where nested true
            if($field!==null AND $operator!==null AND $value!==null){
                self::$whereColumn['field'][]=$field;
                self::$whereColumn['operator'][]=$operator;
                self::$whereColumn['value'][]=$value;

            }
        }
        return new static;

    }


    /**
     * query where year.
     *
     * @return pdo class
     */
    public static function whereYear($year='2016',$field=null){

        //instance check
        if(self::$_instance==null){
            self::$_instance=new self();
        }

        $model=self::staticFlowCallback();

        //if the field value is callback value
        //a callback function is run
        if(is_callable($field)){
            $getclass="\\".get_called_class();
            call_user_func_array($field,[$getclass::staticFlowCallback()]);

        }
        else{
            //where criteria coming with all values
            if($field==null){
                self::$whereYear['year'][]=$year;
                self::$whereYear['field'][]=$model->createdAndUpdatedFields['created_at'];
            }
            else{
                self::$whereYear['year'][]=$year;
                self::$whereYear['field'][]=$field;
            }
        }
        return new static;

    }


    /**
     * query where.
     *
     * @return pdo class
     */
    public static function orWhere($field=null,$operator=null,$value=null,$join=false){

        //instance check
        if(self::$_instance==null){
            self::$_instance=new self();
        }

        //if the field value is callback value
        //a callback function is run
        if(is_callable($field)){
            $getclass="\\".get_called_class();
            call_user_func_array($field,[$getclass::staticFlowCallback()]);

        }
        else{
            //where criteria coming with all values
            //where nested true
            if($field!==null AND $operator!==null AND $value!==null){
                self::$orWhere['field'][]=$field;
                self::$orWhere['operator'][]=$operator;
                self::$orWhere['value'][]=$value;
                if($join){
                    self::$orWhere['join'][]=$join;
                }

            }
        }
        return new static;

    }


    /**
     * query where between.
     *
     * @return pdo class
     */
    public static function between($field=null,$value1=null,$value2=null){

        //instance check
        if(self::$_instance==null){
            self::$_instance=new self();
        }

        if($field!==null AND $value1!==null AND $value2!==null){
            self::$where['field'][]=$field;
            self::$where['operator'][]='BETWEEN';
            self::$where['value'][]=''.$value1.','.$value2.'';
            self::$where['between'][]=':'.md5($value1).' AND :'.md5($value2).' ';

        }

        return new static;

    }


    /**
     * query where between.
     *
     * @return pdo class
     */
    public static function sum($field=null,$query=null){

        //instance check
        if(self::$_instance==null){
            self::$_instance=new self();
        }

        if($field!==null OR $query!==null){
            self::$sum=$field;
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
     * query toSql.
     *
     * @return pdo class
     */
    public static function toSql(){

        self::$toSql="toSql";
        return self::get();

    }

    /**
     * query join.
     *
     * @return pdo class
     */
    public static function join($table=null,$joinType="inner"){

        if($table!==null){
            self::$join=$table;
            $model=new static;
            if(property_exists($model,"joiner")){
                self::$joinType=$model->joiner['auto'];
            }
            else{
                self::$joinType=$joinType;
            }

        }

        return new static;

    }

    /**
     * query rand.
     *
     * @return pdo class
     */
    public static function rand($value=null){

        if($value==null){
            self::$rand=0;
        }
        else{
            if(is_numeric($value)){
                self::$rand=$value;
            }
            else{
                self::$rand=0;
            }

        }

        return self::get();

    }


    /**
     * query rand.
     *
     * @return pdo class
     */
    public static function all(){

        self::$all=1;
        return self::get();

    }


    /**
     * query get.
     *
     * @return pdo class
     */
    public static function get(){

        //get model
        $model=self::staticFlowCallback();

        //get symfony request
        $request=self::$request;

        //url query string
        $getQueryString=$request->getQueryString();

        //get primary key
        self::getPrimaryKeyStatic();

        //select filter
        $select=self::getSelectOperation();

        //get table columns for model
        $columns=self::getShowColumns();

        //initial
        $execute=[];
        $where='';

        //where method
        $whereOperation=self::getWhereOperation();

        //ofset filter
        $offset=self::getOffsetOperation();

        //get Orderby
        $order=self::getOrderByOperation();

        //get join operation
        $join=self::getJoinOperation();

        //get random data
        if(self::$rand!==null){
            $table='(select '.$select.' from '.$model->table.' '.$join.' '.$where.' '.$order.' '.$offset.') as '.$model->table.'';
            $where='';
            $order='ORDER BY RAND()';
            if(self::$rand>0){
                $offset='LIMIT '.self::$rand;
            }

        }

        if(self::$toSql!==null){
           return self::toSqlShow();
        }

        try {
            if(self::$hasMany!==null){
                //get query result
                if(property_exists($model,"redis") && $model->redis['status']){
                    return self::getHasManyQueryRedisResult();
                }
                else{
                    return self::getHasManyQueryResult();
                }
            }
            else{
                //get query result
                if(property_exists($model,"redis") && $model->redis['status']){
                    return self::getQueryRedisResult();
                }
                else{
                    return self::getQueryResult();
                }

            }

        }
        catch(\Exception $e){
            return self::getExceptionResult($e);
        }



    }


    /**
     * query show columns.
     *
     * @return pdo class
     */
    private static function getShowColumns($table=null){
        if($table==null){
            $model=self::staticFlowCallback();
            $showColumns=self::$db->prepare("SHOW COLUMNS FROM ".$model->table."");
            $showColumns->execute();
            return $showColumns->fetchAll(\PDO::FETCH_OBJ);
        }
    }


    /**
     * query to query and to sql.
     *
     * @return pdo class
     */
    private static function toSqlShow(){
        $model=self::staticFlowCallback();
        foreach (self::$execute as $execute_key=>$execute_value){
            $where=str_replace($execute_key,$execute_value,self::getStringWhere());
        }
        return "select ".self::$select." from ".$model->table." ".self::$joiner." ".self::getStringWhere()." ".self::$order." ".self::$offset."";
    }

    /**
     * query paginator count.
     *
     * @return pdo class
     */
    private static function getPaginatorDataCount($data=array()){
        if(self::$offset!==""){
            $model=self::staticFlowCallback();

            $select=(array_key_exists("select",$data)) ? $data['select'] : 'count(*) as total';
            $groupBy=(array_key_exists("groupBy",$data)) ? $data['groupBy'] : '';

            //dd("select ".$select." from ".$model->table." ".self::$joiner." ".self::getStringWhere()." ".self::$order."",self::$execute);

            $query=self::$db->prepare("select ".$select." from ".$model->table." ".self::$joiner." ".self::getStringWhere()." ".$groupBy." ".self::$order."");
            $query->execute(self::$execute);
            return $query->fetchColumn();
        }

        return 0;
    }


    /**
     * query exception method.
     *
     * @return pdo class
     */
    private static function getExceptionResult($e){
        $model=self::staticFlowCallback();
        return [
            'query'=>"select ".self::$select." from ".$model->table." ".self::$joiner." ".self::getStringWhere()." ".self::$order." ".self::$offset."",
            'error'=>$e->getMessage(),
            'code'=>$e->getCode(),
            'file'=>$e->getFile(),
            'line'=>$e->getLine(),
            'trace'=>$e->getTrace()
        ];
    }

    /**
     * query query result.
     *
     * @return pdo class
     */
    private static function getQueryResult(){
        $model=self::staticFlowCallback();
        $query=self::$db->prepare("select ".self::$select." from ".$model->table." ".self::$joiner." ".self::getStringWhere()." ".self::$order." ".self::$offset."");
        $query->execute(self::$execute);
        $results=$query->fetchAll(\PDO::FETCH_OBJ);

        $getTableColumns=self::getTableColumns(self::getShowColumns(),true);
        if(is_array(self::$select)){
            $getTableColumns=self::$select;
        }

        $hiddenLists=[];
        foreach($getTableColumns as $gkey=>$gvalue){
            if(property_exists($model,"selectHidden") && !in_array($gvalue,$model->selectHidden)){
                $hiddenLists[]=$gvalue;
            }
        }

        if(count($hiddenLists)){
            $getTableColumns=$hiddenLists;
        }

        $resultsWithTypes=[];
        foreach($results as $key=>$rwt){
            foreach($getTableColumns as $cols){
                if(property_exists($rwt,$cols)){
                    if(preg_match('@int@is',self::getTypeColumnsFromDatabase($cols))){
                        $resultsWithTypes[$key][$cols]=(int)$rwt->$cols;
                    }
                    elseif(preg_match('@float@is',self::getTypeColumnsFromDatabase($cols))){
                        $resultsWithTypes[$key][$cols]=(float)$rwt->$cols;
                    }
                    elseif(preg_match('@bool@is',self::getTypeColumnsFromDatabase($cols))){
                        if($rwt->$cols>0){
                            $resultsWithTypes[$key][$cols]=(bool)true;
                        }
                        else{
                            $resultsWithTypes[$key][$cols]=(bool)false;
                        }

                    }
                    else{
                        $resultsWithTypes[$key][$cols]=$rwt->$cols;
                    }
                }
            }
        }

        if(count($resultsWithTypes)){
            $results=$resultsWithTypes;
        }


        //get count pagination
        $paginatorCount['dataCount']=self::getPaginatorDataCount();

        //get symfony request
        $request=self::$request;

        //url query string
        $getQueryString=$request->getQueryString();


        $pageNo=(self::checkPageOnQueryString()) ? $getQueryString['page'] : 1;
        $totalPageNo=ceil((int)$paginatorCount['dataCount']/(int)self::$page);

        return [

            'dataCount'=>(int)$paginatorCount['dataCount'],
            'paginator'=>(int)self::$page,
            'totalPageNo'=>(int)$totalPageNo,
            'currentPage'=>(int)$pageNo,
            'data'=>$results

        ];

    }


    /**
     * query query redis result.
     *
     * @return pdo class
     */
    private static function getQueryRedisResult(){
        $model=self::staticFlowCallback();

        $redisInfo=''.self::$select.'_'.$model->table.'_'.self::getStringWhere().'_'.self::$joiner.'_'.self::$order.'__'.self::$offset.'__'.implode(",",self::$execute);
        $redisHash=''.$model->table.'__'.md5($redisInfo).'';

        $redisConnection=\app::container("redis");

        if($redisConnection->exists($redisHash)){
            return unserialize($redisConnection->get($redisHash));
        }

        $result=self::getQueryResult();


        if(count($result['data'])){
            $redisConnection->set([$redisHash,serialize($result)]);
            $redisConnection->expire($redisHash,$model->redis['expire']);
        }

        return $result;
    }


    /**
     * query has Many result.
     *
     * @return pdo class
     */
    private static function getHasManyQueryResult(){
        $model=self::staticFlowCallback();
        $request=self::$request;

        //url query string
        $getQueryString=$request->getQueryString();


        $resultList=[];
        $listAs=self::getJoinOperationFieldAs("list");
        $listAsArray=[];
        foreach($listAs['list'] as $listAsValue){
            if(array_key_exists($listAsValue,$listAs['listAs'])){
                $listAsArray[]="GROUP_CONCAT(".$listAsValue." SEPARATOR '@@@@@___@@@@@') as ".$listAs['listAs'][$listAsValue];
            }
            else{
                $listAsValueEx=explode(".",$listAsValue);
                $listAsArray[]="GROUP_CONCAT(".$listAsValue." SEPARATOR '@@@@@___@@@@@') as ".$listAsValueEx[1];
            }

        }


        //get count pagination
        //get count pagination
        $paginatorCount['dataCount']=self::getPaginatorDataCount(['select'=>''.self::$select.','.implode(",",$listAsArray).'',
        'groupBy'=>'GROUP BY '.$model->table.'.'.self::$hasMany['hasOneField'].'']);

        $query=self::$db->prepare("select ".self::$select.",".implode(",",$listAsArray)." from ".$model->table." ".self::$joiner."
         ".self::getStringWhere()." GROUP BY ".$model->table.".".self::$hasMany['hasOneField']."
                     ".self::$order." ".self::$offset."");
        $query->execute(self::$execute);

        $query=$query->fetchAll(\PDO::FETCH_OBJ);

        $hasManyJoinAs=(array_key_exists("as",$model->joinField[self::$join])) ? $model->joinField[self::$join]['as'] : self::$join;


        foreach($query as $key=>$result){

            foreach(self::getTableColumns(self::getShowColumns(),true) as $fkey){
                if(property_exists($result,$fkey)){
                    if(preg_match('@int@is',self::getTypeColumnsFromDatabase($fkey))){
                        $resultList[$key][$fkey]=(int)$result->$fkey;
                    }
                    elseif(preg_match('@float@is',self::getTypeColumnsFromDatabase($fkey))){
                        $resultList[$key][$fkey]=(float)$result->$fkey;
                    }
                    elseif(preg_match('@bool@is',self::getTypeColumnsFromDatabase($fkey))){
                        $resultList[$key][$fkey]=(bool)$result->$fkey;
                    }
                    else{
                        $resultList[$key][$fkey]=$result->$fkey;
                    }

                }

            }


            $jfkxListe=[];
            foreach(self::getJoinOperationFieldAs(false) as $jfkx){
                $listAsKey=self::getJoinOperationFieldAs("list")['listAs'];
                if(in_array($jfkx,$listAsKey)){
                    $jfkxem=explode(".",array_search($jfkx,$listAsKey));
                    $jfkxListe[$jfkx]=$jfkxem[1];
                }
                else{
                    $jfkxListe[$jfkx]=$jfkx;
                }

                $joins[$key][$jfkx]=explode("@@@@@___@@@@@",$result->$jfkx);
                for($i=0; $i<count($joins[$key][$jfkx]); $i++){
                    if(preg_match('@int@is',self::getTypeColumnsFromDatabase($jfkxListe[$jfkx],self::$join))){
                        $resultList[$key][$hasManyJoinAs][$i][$jfkx]=(int)$joins[$key][$jfkx][$i];
                    }
                    elseif(preg_match('@float@is',self::getTypeColumnsFromDatabase($jfkxListe[$jfkx],self::$join))){
                        $resultList[$key][$hasManyJoinAs][$i][$jfkx]=(int)$joins[$key][$jfkx][$i];
                    }
                    elseif(preg_match('@bool@is',self::getTypeColumnsFromDatabase($jfkxListe[$jfkx],self::$join))){
                        $resultList[$key][$hasManyJoinAs][$i][$jfkx]=(int)$joins[$key][$jfkx][$i];
                    }
                    else{
                        $resultList[$key][$hasManyJoinAs][$i][$jfkx]=$joins[$key][$jfkx][$i];
                    }

                }
            }
        }

        $pageNo=(self::checkPageOnQueryString()) ? $getQueryString['page'] : 1;
        $totalPageNo=ceil((int)$paginatorCount['dataCount']/(int)self::$page);

        return [

            'dataCount'=>(int)$paginatorCount['dataCount'],
            'paginator'=>(int)self::$page,
            'totalPageNo'=>(int)$totalPageNo,
            'currentPage'=>(int)$pageNo,
            'data'=>$resultList

        ];
    }


    /**
     * query query has Many redis result.
     *
     * @return pdo class
     */
    private static function getHasManyQueryRedisResult(){
        $model=self::staticFlowCallback();

        $redisInfo=''.self::$select.'_'.$model->table.'_'.self::getStringWhere().'_'.self::$joiner.'_'.self::$order.'__'.self::$offset.'';
        $redisHash=''.$model->table.'__'.md5($redisInfo).'';

        $redisConnection=\app::container("redis");

        if($redisConnection->exists($redisHash)){
            return unserialize($redisConnection->get($redisHash));
        }
        $redisConnection->set([$redisHash,serialize(self::getHasManyQueryResult())]);
        $redisConnection->expire($redisHash,$model->redis['expire']);
        return self::getHasManyQueryResult();
    }

    /**
     * get primary key .
     *
     * @return pdo class
     */
    public static function getPrimaryKeyStatic(){
        $model=self::staticFlowCallback();
        self::$primarykey_static=(property_exists($model,"primaryKey")) ? $model->primaryKey : 'id';
    }

    /**
     * query get order by operation.
     *
     * @return pdo class
     */
    private static  function getOrderByOperation(){

        $model=new static;

        if(self::$order!==null && is_array(self::$order)){
            $order='';
            $order.='ORDER BY '.$model->table.'.'.self::$order['key'].' '.self::$order['order'].'';

        }
        else{
            $order='';
            if(property_exists($model,"orderBy")){
                if(array_key_exists("auto",$model->orderBy)){
                    foreach ($model->orderBy['auto'] as $order_key => $order_value) {
                        $order .= 'ORDER BY '.$model->table.'.' . $order_key . ' ' . $order_value . '';
                    }
                }
            }
        }

        self::$order=$order;
        return $order;
    }

    /**
     * query get order by operation.
     *
     * @return pdo class
     */
    private static  function getSelectOperation($columns=null){
        //select filter
        $model=self::staticFlowCallback();

        if(self::$sum!==null){
            $as=explode(":",self::$sum);
            if(array_key_exists(1,$as)){
                self::$select='SUM('.$as[0].') as '.$as[1];
            }
            else{
                self::$select='SUM('.$as[0].') as '.$as[0];
            }

        }

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

        //get select hidden
        if(property_exists($model,"selectHidden")){
            //$select=self::getSelectOperation(self::getShowColumns());
        }

        //values coming from join type
        if(self::$joinTypeField!==null){
            if($select!=="*"){
                $selectVal=explode(",",$select);
                $selectList=[];
                foreach($selectVal as $val){
                    $selectList[]=''.$model->table.'.'.$val.'';
                }

                $select=implode(",",$selectList);
            }

            $select=($select=="*") ? implode(",",self::getTableColumns($columns)) : $select;
            $select=''.$select.','.implode(",",self::$joinTypeField).'';

            self::$where=preg_replace('@:(\w+)\.@is',':',$where);
            $executeList=[];
            foreach($execute as $execute_key=>$execute_val){
                $executeList[preg_replace('@:(\w+)\.@is',':',$execute_key)]=$execute_val;
            }
            self::$execute=$executeList;
        }

        self::$select=$select;
        return $select;

    }

    /**
     * query get where string.
     *
     * @return pdo class
     */
    private static function getStringWhere(){
        return (count(self::$where)) ? self::$where : '';
    }

    /**
     * query get where operation.
     *
     * @return pdo class
     */

    private static function getWhereOperation(){

        $list=[];
        $model=self::staticFlowCallback();

        //model scope
        self::$where=self::getScopeOperation();

        if(count(self::$whereYear)){
            foreach(self::$whereYear['year'] as $fkey=>$fvalue){
                self::$where['field'][]='YEAR'.$fkey.''.self::$whereYear['field'][$fkey];
                self::$where['operator'][]="=";
                self::$where['value'][]='YEAR'.$fkey.'-'.self::$whereYear['year'][$fkey];
            }

        }


        if(count(self::$whereColumn)){
            foreach(self::$whereColumn['field'] as $fkey=>$fvalue){
                self::$where['field'][]='COLUMN'.self::$whereColumn['field'][$fkey];
                self::$where['operator'][]=self::$whereColumn['operator'][$fkey];
                self::$where['value'][]='COLUMN'.self::$whereColumn['value'][$fkey];
            }

        }

        //find method
        if(self::$find!==null){
            self::getFindOperation();
        }
        else{
            if(count(self::$where) OR self::$whereIn!==null OR self::$whereNotIn!==null){

                if(self::$whereIn!==null OR self::$whereNotIn!==null){
                    if(count(self::$where)==0){
                        self::$where['field'][]=self::$primarykey_static;
                        self::$where['operator'][]=">";
                        self::$where['value'][]=0;

                    }

                }



                $fieldPrepareArray=[];
                $fieldPrepareArrayExecute=[];
                foreach(self::$where['field'] as $field_key=>$field_value){
                    if(self::$where['operator'][$field_key]=="BETWEEN"){
                        $fieldPrepareArray[]=''.$field_value.' '.self::$where['operator'][$field_key].' '.self::$where['between'][$field_key].' ';
                        $whereBetweenValue=explode(",",self::$where['value'][$field_key]);
                        foreach($whereBetweenValue as $wbv){
                            $fieldPrepareArrayExecute[':'.md5($wbv).'']=$wbv;
                        }

                    }
                    else{
                        if(preg_match('@COLUMN@is',$field_value)){
                            $fieldPrepareArray['list'][]=''.str_replace('COLUMN','',$field_value).''.self::$where['operator'][$field_key].''.str_replace('COLUMN','',self::$where['value'][$field_key]).'';
                        }
                        elseif(preg_match('@YEAR(\d+)@is',$field_value)){
                            $fieldPrepareArray['year'][]='FROM_UNIXTIME('.preg_replace('@YEAR(\d+)@is','',$field_value).',"%Y")=:'.$field_value;
                        }
                        else{
                            $fieldPrepareArray['list'][]=''.$field_value.''.self::$where['operator'][$field_key].':'.$field_value.'';
                        }

                        if(!preg_match('@COLUMN|YEAR@is',self::$where['value'][$field_key])){
                            $fieldPrepareArrayExecute[':'.$field_value.'']=self::$where['value'][$field_key];
                        }

                        if(preg_match('@YEAR(\d+)@is',self::$where['value'][$field_key])){
                            $fieldPrepareArrayExecute[':'.$field_value.'']=(int)preg_replace('@YEAR(\d+)\-@is','',self::$where['value'][$field_key]);
                        }



                    }

                }

                //dd($fieldPrepareArray,$fieldPrepareArrayExecute,self::$where);

                if(array_key_exists("list",$fieldPrepareArray)){
                    $list['where']='WHERE '.implode(" AND ",$fieldPrepareArray['list']);
                }


                if(array_key_exists("year",$fieldPrepareArray)){
                    $whereExtension=(array_key_exists("list",$fieldPrepareArray)) ? ''.$list['where'].' AND ' : 'WHERE ';
                    $list['where']=''.$whereExtension.' ('.implode(" OR ",$fieldPrepareArray['year']).')';
                }


                $list['execute']=$fieldPrepareArrayExecute;


                //dd($list);

                if(self::$whereIn!==null && is_array(self::$whereIn)){
                    $whereIn=self::getWhereInString();
                    $list['where']=$list['where'].' AND '.$whereIn['prepare'];
                    $list['execute']=$list['execute']+$whereIn['execute'];

                }


                if(self::$whereNotIn!==null && is_array(self::$whereNotIn)){
                    $whereNotIn=self::getWhereNotInString();
                    $list['where']=$list['where'].' AND '.$whereNotIn['prepare'];
                    $list['execute']=$list['execute']+$whereNotIn['execute'];

                }

                self::$where=$list['where'];
                self::$execute=$list['execute'];

                if(count(self::$where) && count(self::$orWhere)){
                    self::getOrWhereOperation();
                }
            }


        }

        return $list;
    }


    /**
     * query get or where operation.
     *
     * @return pdo class
     */
    private static function getOrWhereOperation(){
        $list=[];

        if(array_key_exists("join",self::$orWhere) && count(self::$orWhere['join'])>1){
            $joinOrWhereList=[];
            foreach(self::$orWhere['field'] as $field_key=>$field_value){
                $joinOrWhereList[self::$orWhere['join'][$field_key]]['field'][$field_key]=self::$orWhere['field'][$field_key];
                $joinOrWhereList[self::$orWhere['join'][$field_key]]['operator'][$field_key]=self::$orWhere['operator'][$field_key];
                $joinOrWhereList[self::$orWhere['join'][$field_key]]['value'][$field_key]=self::$orWhere['value'][$field_key];
            }

            foreach($joinOrWhereList as $key=>$array){
                foreach($array['field'] as $field_key=>$field_value){
                    $list['prepare'][$key][]=''.$field_value.''.$array['operator'][$field_key].':'.$field_value.''.$key.''.$field_key.'';
                    $list['execute'][':'.$field_value.''.$key.''.$field_key.'']=$array['value'][$field_key];
                }
            }

            $prepareLists=[];
            foreach($list['prepare'] as $key=>$value){
                $prepareLists[]='('.implode(" OR ",$list['prepare'][$key]).')';
            }


            self::$where=self::$where.' AND '.implode(" AND ",$prepareLists).'';
            self::$execute=self::$execute+$list['execute'];




        }
        else{
            foreach(self::$orWhere['field'] as $field_key=>$field_value){
                $list['prepare'][]=''.$field_value.''.self::$orWhere['operator'][$field_key].':'.$field_value.''.$field_key.'';
                $list['execute'][':'.$field_value.''.$field_key.'']=self::$orWhere['value'][$field_key];
            }

            self::$where=self::$where.' OR '.implode(" OR ",$list['prepare']);
            self::$execute=self::$execute+$list['execute'];
        }

    }


    /**
     * query get checkPageOnQueryString operation.
     *
     * @return pdo class
     */
    private static function checkPageOnQueryString(){
        $request=self::$request;
        $getQueryString=$request->getQueryString();
        if(count($getQueryString)) {
            if (array_key_exists("page", $getQueryString)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * query get Where In operation.
     *
     * @return pdo class
     */
    private static function getWhereInString(){
        if(self::$whereIn!==null && is_array(self::$whereIn)){
            foreach(self::$whereIn['data'] as $key=>$value){
                $prepare[]=':a'.$key.'';
                $execute[':a'.$key.'']=$value;
            }
            return ['prepare'=>self::$whereIn['field'].' IN ('.implode(",",$prepare).')','execute'=>$execute];
        }
        return '';

    }


    /**
     * query get Where Not In operation.
     *
     * @return pdo class
     */
    private static function getWhereNotInString(){
        if(self::$whereNotIn!==null && is_array(self::$whereNotIn)){
            foreach(self::$whereNotIn['data'] as $key=>$value){
                $prepare[]=':a'.$key.'';
                $execute[':a'.$key.'']=$value;
            }
            return ['prepare'=>self::$whereNotIn['field'].' NOT IN ('.implode(",",$prepare).')','execute'=>$execute];
        }
        return '';

    }




    /**
     * query get find operation.
     *
     * @return pdo class
     */
    private static function getFindOperation(){

        if(is_array(self::$find)){

            $prepare=[];
            $preparare_execute=[];
            foreach(self::$find as $key=>$value){
                $prepare[]=''.self::$primarykey_static.''.$key.'=:'.self::$primarykey_static.''.$key.'';
                $prepare_execute[':'.self::$primarykey_static.''.$key.'']=$value;
            }

            $placeholders = str_repeat ('?,', count(self::$find)-1).'?';
            self::$where='WHERE '.self::$primarykey_static.' IN ('.$placeholders.')';
            self::$execute=self::$find;

        }
        else{
            self::$where='WHERE '.self::$primarykey_static.'=:'.self::$primarykey_static.'';
            self::$execute=array(':'.self::$primarykey_static.''=>self::$find);
        }

    }


    /**
     * query get offset operation.
     *
     * @return pdo class
     */

    private static function getOffsetOperation(){

        $list=[];
        $model=self::staticFlowCallback();
        $request=self::$request;

        if(self::$page==null && property_exists($model,"paginator")){
            if(array_key_exists("auto",$model->paginator)){
                self::$page=$model->paginator['auto'];
            }
        }


        if(self::$page!==null){

            $offset=0;
            $request=self::$request;
            $getQueryString=$request->getQueryString();
           if(self::checkPageOnQueryString()){
               $offset=$getQueryString['page']-1;
               $offset=$offset*self::$page;
           }

            $offsetparam='';
            if(self::$all==null){
                $offsetparam.='LIMIT ';
                $offsetparam.=$offset;
                $offsetparam.=',';
                $offsetparam.=self::$page;

            }
        }

        self::$offset=$offsetparam;
        return $offsetparam;

    }


    /**
     * query get join operation.
     *
     * @return pdo class
     */

    private static function getJoinOperation(){

        $list='';
        if(self::$join!==null){
            $model=new static;
            if(property_exists($model,"joinField")){
                $joiTypeFieldList=[];
                self::$joinTypeField=self::getJoinOperationFieldAs(true);


                if(array_key_exists("match",$model->joinField[self::$join])){
                    $list.=''.self::$joinType.' JOIN '.self::$join.' ON '.$model->table.'.'.$model->joinField[self::$join]['match'].'='.self::$join.'.id';
                }

                if(array_key_exists("hasOne",$model->joinField[self::$join])){
                    $hasOne=explode(":",$model->joinField[self::$join]['hasOne']);
                    $hasOneField=(!array_key_exists(1,$hasOne)) ? 'id' : $hasOne[1];

                    $list.=''.self::$joinType.' JOIN '.self::$join.' ON '.$model->table.'.'.$hasOneField.'='.self::$join.'.'.$hasOne[0];

                }

                if(array_key_exists("hasMany",$model->joinField[self::$join])){
                    $hasOne=explode(":",$model->joinField[self::$join]['hasMany']);
                    $hasOneField=(!array_key_exists(1,$hasOne)) ? 'id' : $hasOne[1];

                    $list.=''.self::$joinType.' JOIN '.self::$join.' ON '.$model->table.'.'.$hasOneField.'='.self::$join.'.'.$hasOne[0];

                    self::$hasMany=["status"=>1,"hasOneField"=>$hasOneField,"joinHasOne"=>$hasOne[0],"hasManyJoinField"=>$model->joinField[self::$join]['joinField']];

                }

            }
        }

        self::$joiner=$list;
        return $list;

    }


    /**
     * query get join operation.
     *
     * @return pdo class
     */

    private static function getJoinOperationFieldAs($type=false){
        $model=new static;
        $joiTypeFieldList=[];
        $joinTypeAs=[];
        $joinTypeAsList=[];
        $joinTypeAsListAs=[];
        foreach ($model->joinField[self::$join]['joinField'] as $jtf){
            $jtf=explode("/",$jtf);
            if(array_key_exists(1,$jtf)){
                $joiTypeFieldList[]=''.self::$join.'.'.$jtf[0].' as '.$jtf[1];
                $joinTypeAsList[]=''.self::$join.'.'.$jtf[0].'';
                $joinTypeAsListAs[''.self::$join.'.'.$jtf[0].'']=$jtf[1];
                $joinTypeAs[]=$jtf[1];
            }
            else
            {
                $joiTypeFieldList[]=''.self::$join.'.'.$jtf[0];
                $joinTypeAsList[]=''.self::$join.'.'.$jtf[0].'';
                $joinTypeAs[]=$jtf[0];
            }

        }



        if($type===false){
            return $joinTypeAs;
        }

        if($type==="list"){

            return ['list'=>$joinTypeAsList,'listAs'=>$joinTypeAsListAs];
        }

        return $joiTypeFieldList;
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
        if(self::$modelscope!==false){
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
        }


        return self::$where;
    }


    /**
     * query scope where operation.
     *
     * @return pdo class
     */

    private static function getTableColumns($columns=null,$pure=false){

        //get model
        $model=new static;

        $list=[];
        if($columns!==null){
            foreach($columns as $cols){
                if($pure==false){
                    $list[]=''.$model->table.'.'.$cols->Field.'';
                }
                else{
                    $list[]=''.$cols->Field.'';
                }

            }
        }

        return $list;

    }


    private static function getTypeColumnsFromDatabase($field=null,$table=null){

        $model=new static;
        $table=($table==null) ? $model->table : $table;

        $showColumns=self::$db->prepare("SHOW COLUMNS FROM ".$table."");
        $showColumns->execute();
        $columns=$showColumns->fetchAll(\PDO::FETCH_OBJ);

        $list=[];
        foreach($columns as $result){
            if($result->Type=="tinyint(1)"){
                $list[$result->Field]="bool";
            }
            else{
                $list[$result->Field]=$result->Type;
            }

        }

        if($field==null){
            return $list;
        }
        else{
            return $list[$field];
        }
    }


    /**
     * query insert operation.
     *
     * @return pdo class
     */

    public static function insert($data=array(),$callback=false){
        //get callable
        $postStatus=false;

        $model=new static;

        $input=self::$request->input();

        $insertedPost=[];
        if(property_exists($model,"insertedPost")){
            $insertedPost=$model->insertedPost;
        }

        if(count($input)){
            foreach($input as $key=>$value){
                if($key!=="_token"){
                    if(count($insertedPost)){
                        if(in_array($key,$insertedPost)){
                            $data[$key]=$value;
                        }
                    }
                    else{
                        $data[$key]=$value;
                    }

                }
            }
        }

        if(count($data)){

            if(property_exists($model,"createdAndUpdatedFields")){
                $createdAt=$model->createdAndUpdatedFields['created_at'];
                $updatedAt=$model->createdAndUpdatedFields['updated_at'];

                $time=time();
                $data[$createdAt]=$time;
                $data[$updatedAt]=$time;
            }

            $dataKeyValues=[];
            $dataPrepareValues=[];
            $dataExecuteValues=[];

            foreach($data as $key=>$value){
                $dataKeyValues[]=$key;
                $dataPrepareValues[]='?';
                $dataExecuteValues[]=$value;
            }

            $dbh=self::$db;

            if(!is_callable($callback)){
                $query=self::$db->prepare("INSERT INTO ".$model->table." (".implode(",",$dataKeyValues).") VALUES (".implode(",",$dataPrepareValues).")");
                return $query->execute($dataExecuteValues);
            }


            try {
                self::$db->beginTransaction();
                $query=$dbh->prepare("INSERT INTO ".$model->table." (".implode(",",$dataKeyValues).") VALUES (".implode(",",$dataPrepareValues).")");
                $query->execute($dataExecuteValues);
                self::$db->commit();
                $postStatus=true;

            }
            catch(\Exception $e){
                self::$db->rollBack();
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
        if($postStatus && is_callable($callback)){
            return call_user_func($callback);
        }

        if(count($data)==false){
            return [
                'error'=>true,
                'message'=>'postdata is invalid'
            ];
        }






    }



    /**
     * query transaction operation.
     *
     * @return pdo class
     */
    public static function transaction($callback){

        new self;

        try {
            self::$db->beginTransaction();

            //$query=self::$db->prepare("insert into users (firstName,lastName) values (?,?)");
            //$query->execute(array("kk","kk2"));
            if(is_callable($callback)){
                call_user_func($callback);
            }
            self::$db->commit();
            return true;
        } catch(\Exception $e) {
            self::$db->rollBack();
            return [
                'error'=>true,
                'message'=>$e->getMessage(),
                'trace'=>$e->getTrace()
            ];

        }
    }




}
