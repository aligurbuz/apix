<?php
/*
 * This file is main part of the sudb.
 *
 * model is called for model file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\packages\providers\database\sudb\src;
use \src\store\packages\providers\database\sudb\src\querySqlFormatter as querySqlFormatter;
use \src\store\packages\providers\database\sudb\src\selectBuilderOperation as selectBuilderOperation;
use \src\store\packages\providers\database\sudb\src\joinBuilderOperation as joinBuilderOperation;
use \src\store\packages\providers\database\sudb\src\whereBuilderOperation as whereBuilderOperation;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class builder {


    private $model=null;
    private $select="*";
    private $setField=null;
    private $substring=null;
    private $find=null;
    private $where=[];
    private $whereIn=[];
    private $whereNotIn=[];
    private $max=null;
    private $min=null;
    private $page=0;
    private $order=null;
    private $groupBy=null;
    private $execute=[];
    private $querySqlFormatter;
    private $selectBuilderOperation;
    private $whereBuilderOperation;
    private $subClassOf=null;
    private $autoScope=null;
    private $bool=[];
    private $saveNew=null;
    private $saveOld=null;
    private $transaction=false;
    private $transactionName=null;
    private $all=false;
    private $join=[];
    private $joinBuilderOperation;

    private static $primarykey_static=null;
    private static $modelscope=null;
    private static $request=null;
    private static $toSql=null;
    private static $rand=null;
    private static $callstatic_scope=[];
    private static $joinType=null;
    private static $joinTypeField=null;
    private static $hasMany=null;
    private static $attach=null;
    private static $sum=null;
    private static $joiner='';
    private static $orWhere=[];
    private static $addToSelectSql=null;
    private static $having=[];

    public function __construct(querySqlFormatter $querySqlFormatter,selectBuilderOperation $selectBuilderOperation,joinBuilderOperation $joinBuilderOperation,whereBuilderOperation $whereBuilderOperation){
        $this->querySqlFormatter=$querySqlFormatter;
        $this->selectBuilderOperation=$selectBuilderOperation;
        $this->joinBuilderOperation=$joinBuilderOperation;
        $this->whereBuilderOperation=$whereBuilderOperation;
    }

    /**
     * scope method is main method.
     *
     * @return array
     */
    public function initial($data=null,$model=null){
        if($this->model==null){
            $this->model=$model;
        }
        return $this;
    }

    /**
     * bool method applies according to boolean value is true.
     *
     * @return array
     */
    public function bool($data=null,$model=null){
        if($this->model==null){
            $this->model=$model;
        }

        if(is_array($data) && count($data)){
            if(is_array($data[0])){
                foreach($data[0] as $key=>$value){
                    $this->bool[]=(bool)$value;
                }
            }
            else{
                $this->bool[]=(bool)$data[0];
            }

        }
        else{
            $this->bool[]=(bool)true;
        }
        return $this;
    }


    /**
     * select method is main method.
     *
     * @return array
     */
    public function select($select=null,$model=null){
        if($this->model==null){
            $this->model=$model;
        }

        if(is_array($select) && $model!==null){
            if(array_key_exists(0,$select) && count($select[0])){
                $this->select=$select[0];
            }

        }
        else{
            if(count($select)){
                $this->select=$select;
            }
        }

        return $this;
    }


    /**
     * set select field method is main method.
     * @forexample : user::select(['id','firstName'])->setField(['bookName'=>['users.bookId@books.id',['book']]])->get();
     * first key : alias fieldname
     * first value matching
     * second array ;wanted fields
     * @return array
     */
    public function setField($select=null,$model=null){
        if($this->model==null){
            $this->model=$model;
        }

        if(is_array($select) && $model!==null){
            if(array_key_exists(0,$select) && count($select[0])){
                $this->setField=$select[0];
            }

        }
        else{
            if(count($select)){
                $this->setField=$select;
            }
        }

        return $this;
    }


    /**
     * set select field method is main method.
     * @forexample : user::substring(['roles.id','-','roles'])->get();
     * first key : tablo information joined
     * second value explode seperate that on first table
     * third value ; information exploded
     * @return array
     */
    public function substring($select=null,$model=null){
        if($this->model===null){
            $this->model=$model;
        }

        if(is_array($select) && $model!==null){
            if(array_key_exists(0,$select) && count($select[0])){
                $this->substring=$select[0];
            }

        }
        else{
            if(count($select)){
                $this->substring=$select;
            }
        }

        return $this;
    }


    /**
     * callback method is main method.
     *
     * @return array
     */
    public function callback($field=null,$model=null){

        if($this->model===null){
            $this->model=$model;

            if(is_callable($field[0])){

                call_user_func_array($field[0],[$this->model]);
            }
        }
        else{
            if(is_callable($field)){

                call_user_func_array($field,[$this->model]);
            }
        }



        return $this;
    }


    /**
     * where method is main method.
     *
     * @return array
     */
    public function where($field=null,$operator=null,$value=null,$model=null){
        if(is_callable($field)){
            if($operator!==null){
                $this->model=$operator;
            }
            call_user_func_array($field,[$this->model]);
        }
        else{

            if($this->model==null){
                $this->model=$model;
            }

            if($field!==null && $operator!==null && $value!==null){
                $this->where['field'][]=$field;
                $this->where['operator'][]=$operator;
                if(is_callable($value)){
                    $value=call_user_func($value);
                    $jsonValCheck=json_decode(json_encode($value),1);
                    if(is_array($jsonValCheck)){
                        $this->where['value'][]=null;
                    }
                    else{
                        $this->where['value'][]=$value;
                    }

                }
                elseif(is_array($value)){
                    $this->where['value']=''.$value[0]::where($value[1][0],"=",$value[1][1])->data()->$value[2];
                }
                else{
                    $this->where['value'][]=$value;
                }

            }


        }

        return $this;
    }



    /**
     * where method is main method.
     *
     * @return array
     */
    public function whereIn($field=null,$value=null,$model=null){
        if($this->model==null){
            $this->model=$value;
        }

        if(is_array($field) && array_key_exists(1,$field)){
            if(is_array($field[1])){
                $this->whereIn['field']=$field[0];
                $this->whereIn['operator']='=';
                $this->whereIn['value']=implode(",",$field[1]);
            }

        }
        else{
            if(is_array($value)){
                $this->whereIn['field']=$field;
                $this->whereIn['operator']='=';
                $this->whereIn['value']=implode(",",$value);
            }

        }

        return $this;
    }


    /**
     * where method is main method.
     *
     * @return array
     */
    public function whereNotIn($field=null,$value=null,$model=null){
        if($this->model==null){
            $this->model=$value;
        }

        if(is_array($field) && array_key_exists(1,$field)){
            if(is_array($field[1])){
                $this->whereNotIn['field']=$field[0];
                $this->whereNotIn['operator']='=';
                $this->whereNotIn['value']=implode(",",$field[1]);
            }

        }
        else{
            if(is_array($value)){
                $this->whereNotIn['field']=$field;
                $this->whereNotIn['operator']='=';
                $this->whereNotIn['value']=implode(",",$value);
            }

        }

        return $this;
    }





    /**
     * where between method is main method.
     *
     * @return array
     */
    public function whereBetween($field=null,$operator=null,$value=null,$model=null){

        if($this->model==null){
            $this->model=$operator;
        }

        if($field!==null && is_array($field)){

            if(array_key_exists(0,$field) && array_key_exists(1,$field) && array_key_exists(2,$field)){
                $this->where['field'][]='between_'.$field[0];
                $this->where['operator'][]=$field[1];
                $this->where['value'][]=$field[2];
            }

        }
        else{

            if($field!==null && $operator!==null && $value!==null){
                $this->where['field'][]='between_'.$field;
                $this->where['operator'][]=$operator;
                $this->where['value'][]=$value;
            }

        }

        return $this;
    }


    /**
     * where between method is main method.
     *
     * @return array
     */
    public function whereNotBetween($field=null,$operator=null,$value=null,$model=null){

        if($this->model==null){
            $this->model=$operator;
        }

        if($field!==null && is_array($field)){

            if(array_key_exists(0,$field) && array_key_exists(1,$field) && array_key_exists(2,$field)){
                $this->where['field'][]='notbetween_'.$field[0];
                $this->where['operator'][]=$field[1];
                $this->where['value'][]=$field[2];
            }

        }
        else{

            if($field!==null && $operator!==null && $value!==null){
                $this->where['field'][]='between_'.$field;
                $this->where['operator'][]=$operator;
                $this->where['value'][]=$value;
            }

        }

        return $this;
    }



    /**
     * where today createdAt method is main method.
     *
     * @return array
     */
    public function today($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        $this->where['field'][]='today';
        $this->where['operator'][]=null;
        $this->where['value'][]=null;

        return $this;
    }

    /**
     * where weekly createdAt method is main method.
     *
     * @return array
     */
    public function weekly($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        $this->where['field'][]='weekly';
        $this->where['operator'][]=null;
        $this->where['value'][]=null;

        return $this;
    }

    /**
     * where yesterday createdAt method is main method.
     *
     * @return array
     */
    public function yesterday($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        $this->where['field'][]='yesterday';
        $this->where['operator'][]=null;
        $this->where['value'][]=null;

        return $this;
    }


    /**
     * query order by.
     *
     * @return pdo class
     */
    public function orderBy($key=null,$order=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        if($key!==null && is_array($key)){
            $this->model=$order;

            if(count($key)){
                $this->order=['key'=>$key[0],'order'=>$key[1]];
            }

        }
        else{
            if($key!==null && $order!==null){
                $this->order=['key'=>$key,'order'=>$order];
            }

        }
        return $this;

    }

    /**
     * query group by.
     *
     * @return pdo class
     */
    public function groupBy($key=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        if(is_array($key)){
            $this->groupBy=$key[0];
        }
        else{
            $this->groupBy=$key;
        }


        return $this;

    }


    /**
     * query group by.
     *
     * @return pdo class
     * @using join(['modelName'],'inner|left|right',['modelName'=>['field1','field2']]
     */
    public function join($join=null,$model=null,$extension=null){

        if(count($join)){
            if($this->model===null){

                $this->join=['joiner'=>$join];

                $this->model=$model;

                if(array_key_exists(1,$join) && !is_array($join[1])){
                    $this->join['type']=$join[1];

                    if(array_key_exists(2,$join) && is_array($join[2])){
                        $this->join['select']=$join[2];
                    }
                    else{
                        $this->join['select']=[];
                    }
                }
                else{
                    $this->join['type']='left';
                    if(is_array($join[1])){
                        $this->join['select']=$join[1];
                    }
                    else{
                        $this->join['select']=[];
                    }
                }

            }
            else{

                $this->join=['joiner'=>[$join]];

                if($model!==null && !is_array($model)){
                    $this->join['type']=$model;

                    if($extension!==null && is_array($extension)){
                        $this->join['select']=$extension;
                    }
                    else{
                        $this->join['select']=[];
                    }
                }
                else{
                    $this->join['type']='left';
                    $this->join['select']=$model;
                }

            }
        }
        else{

            if($this->model===null){
                $this->model=$model;
            }
        }


        return $this;

    }

    /**
     * paginate method is main method.
     *
     * @return array
     */
    public function paginate($paginate=null,$model=null){
        if($this->model==null){
            $this->model=$model;
        }

        if(is_array($paginate)){
            if(array_key_exists(0,$paginate)){
                $this->page=$paginate[0];
            }

        }
        else{
            $this->page=$paginate;
        }

        return $this;
    }


    /**
     * where find method.
     *
     * @return array
     */
    public function find($value=null,$select=null,$model=null){

        if($this->model==null){
            $this->model=$select;
        }

        if(is_array($value)){
            if(count($value) && array_key_exists(0,$value)){

                if(array_key_exists(1,$value)){
                    $this->select($value[1]);
                }

                if(property_exists($this->model->subClassOf,"primaryKey")){
                    $primaryKey=$this->model->subClassOf->primaryKey;
                }
                else{
                    $primaryKey='id';
                }

                if(is_array($value[0])){
                    $this->whereIn($primaryKey,$value[0]);
                }
                else{

                    if(property_exists($this->model->subClassOf,"primaryKey")){
                        $this->where['field'][]=$this->model->subClassOf->primaryKey;
                    }
                    else{
                        $this->where['field'][]='id';
                    }

                    $this->where['operator'][]='=';
                    $this->where['value'][]=$value[0];
                }

            }

        }



        return $this->get();
    }

    /**
     * get method is main method.
     *
     * @return array
     */
    public function get($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        return $this->allMethodProcess(function(){
            $result=$this->queryFormatter();

            if(array_key_exists("paginator",$result) && $result['paginator']>0){

                $countAllData=array_key_exists('CountAllData',$result['resultDataInfo']) ? $result['resultDataInfo']['CountAllData'] : 'CountAllData';
                $paginator=array_key_exists('paginator',$result['resultDataInfo']) ? $result['resultDataInfo']['paginator'] : 'paginator';
                $currentPage=array_key_exists('currentPage',$result['resultDataInfo']) ? $result['resultDataInfo']['currentPage'] : 'currentPage';
                $lastPaginator=array_key_exists('lastPage',$result['resultDataInfo']) ? $result['resultDataInfo']['lastPage'] : 'lastPage';

                $lastpage=(int)$result['getCountAllTotal']/(int)$result['paginator'];
                return [
                    $countAllData=>(int)$result['getCountAllTotal'],
                    $paginator=>(int)$result['paginator'],
                    $currentPage=>(int)$result['currentPage'],
                    $lastPaginator=>(int)ceil($lastpage),
                    'results'=>$this->getColumnsType($result)
                ];
            }
            else{
                return $result['result'];
            }

        });

    }


    /**
     * get method is main method.
     *
     * @return array
     */
    public function toSql($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        return $this->allMethodProcess(function(){
            $result=$this->queryFormatter();
            foreach($result['execute'] as $key=>$value){
                $result['prepare']=str_replace($key,$value,$result['prepare']);
            }

            return $result['prepare'];

        });

    }



    /**
     * all method is main method.
     *
     * @return array
     */
    public function all($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }
        return $this->allMethodProcess(function(){
            $this->all=true;
            $result=$this->queryFormatter();

            if(array_key_exists("paginator",$result) && $result['paginator']>0){
                $lastpage=(int)$result['getCountAllTotal']/(int)$result['paginator'];

                $countAll=[];
                $resultdata=[];
                if($this->max===null){
                    $countAll['CountAllData']=(int)$result['getCountAllTotal'];
                }

                $resultdata['results']=$this->getColumnsType($result['result'],$result['columns'],$result['fields']);

                return $countAll+$resultdata;
            }
            else{
                return $result['result'];
            }

        });

    }


    /**
     * data method is main method.
     *
     * @return string
     */
    public function data($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        if($args===null){
            $args=[];
        }


        $model=$this->model;
        return $this->allMethodProcess(function() use ($args,$model){
            $result=$this->queryFormatter();

            if(array_key_exists(0,$result['result'])){
                $result['result'][0]->count=$result['getCountAllTotal'];

                if(array_key_exists(0,$args) && is_callable($args[0])){
                    $callBackData=call_user_func_array($args[0],[$result['result'][0]]);
                    $this->saveNew=$result['result'][0];
                    return $this;
                }
                elseif(is_callable($args)){
                    call_user_func_array($args,[$result['result'][0]]);
                    $this->saveNew=$result['result'][0];
                    return $this;
                }
                else{
                    return $result['result'][0];
                }

            }
            return (object)[];


        });

    }

    /**
     * save method is main method.
     *
     * @return string
     */
    public function save(){
        if($this->saveNew===null){
            return null;
        }
        $result=json_decode(json_encode($this->saveNew),1);

        $list=[];
        foreach ($result as $key=>$value ){
            if($this->model->subClassOf->primaryKey!==$key && $key!=="count"){
                if($this->model->subClassOf->createdAndUpdatedFields['updated_at']==$key){
                    $list[$key]=time();
                }
                else{
                    $list[$key]=$value;
                }

            }
        }

        $model=$this->model->subClassOf;
        return $model::where($this->model->subClassOf->primaryKey,"=",$result[$this->model->subClassOf->primaryKey])->update($list);

    }


    /**
     * count method is main method.
     *
     * @return string
     */
    public function count($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        return $this->allMethodProcess(function() use ($args,$model){
            $result=$this->queryFormatter();
            return ['CountAllData'=>$result['getCountAllTotal']];


        });

    }


    /**
     * first method is main method.
     *
     * @return string
     */
    public function first($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }
        return $this->allMethodProcess(function(){
            $result=$this->queryFormatter();

            if(array_key_exists(0,$result['result'])){
                return ['result'=>$result['result'][0]];
            }
            return [];


        });

    }


    /**
     * max method is main method.
     *
     * @return string
     */
    public function max($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }
        if(is_array($args) && array_key_exists(0,$args)){
            $this->max=$args[0];
        }
        else{
            $this->max=$args;
        }
        return $this->get();

    }


    /**
     * max method is main method.
     *
     * @return string
     */
    public function min($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }
        if(is_array($args) && array_key_exists(0,$args)){
            $this->min=$args[0];
        }
        else{
            $this->min=$args;
        }
        return $this->get();

    }


    /**
     * first method is main method.
     *
     * @return string
     */
    public function firstOrFail($args=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }
        return $this->allMethodProcess(function(){
            $result=$this->queryFormatter();

            if(array_key_exists(0,$result['result'])){
                return (object)['data'=>$result['result'][0]];
            }
            return [
                'error'=>true,
                'code'=>204,
                'message'=>'no data'

            ];


        });

    }

    /**
     * get method is main method.
     *
     * @return array
     */
    private function queryFormatter(){
        return $this->querySqlFormatter->getSqlPrepareFormatter($this->SqlPrepareFormatterHandleObject());
    }

    /**
     * get columns type is main method.
     *
     * @return array
     */
    private function getColumnsType($result){

        $data=$result['result'];
        $types=$result['columns'];
        $fields=$result['fields'];
        $list=[];
        if($fields!==null && $data!==false){
            foreach ($fields as $key=>$value) {
                foreach($data as $dkey=>$dvalue){
                    if(array_key_exists($key,$types['type'])){
                        if(preg_match('@int@is',$types['type'][$key])){
                            $list[$dkey][$key]=(int)$dvalue->$key;
                        }
                        elseif(preg_match('@float@is',$types['type'][$key])){
                            $list[$dkey][$key]=(float)$dvalue->$key;
                        }
                        elseif(preg_match('@bool@is',$types['type'][$key])){
                            $list[$dkey][$key]=(bool)$dvalue->$key;
                        }
                        else{
                            $list[$dkey][$key]=$dvalue->$key;
                        }
                    }
                    else{
                        if(preg_match('@groupBy.*Total@is',$key)){
                            $list[$dkey][$key]=(int)$dvalue->$key;
                        }
                    }

                }
            }
        }

        return $this->resultRelationObjectGrouping($result,$list);


    }

    private function resultRelationObjectGrouping($result,$list){

        if(isset($result['modelData']['join']['selectGroup'])){

            $listData=[];
            $selectGroup=$result['modelData']['join']['selectGroup'];

            $groupList=[];
            foreach ($selectGroup as $group=>$groupArray){

                foreach ($groupArray as $gk=>$gv){
                    $groupList[$gv]=$group;
                }
            }

            foreach ($list as $key=>$data){

                foreach ($list[$key] as $resultKey=>$resultData){

                    if(isset($groupList[$resultKey])){
                        $listData[$key][$groupList[$resultKey]][$resultKey]=$resultData;
                    }
                    else{
                        $listData[$key][$resultKey]=$resultData;
                    }

                }
            }

            $list=$listData;
        }

        return $list;
    }

    /**
     * subClassOf method is main method.
     *
     * @return array
     */
    public function subClassOf($class){
        $this->subClassOf=$class;
    }

    /**
     * subClassOf method is main method.
     *
     * @return array
     */
    private function SqlPrepareFormatterHandleObject(){
        return [
            'model'=>$this->subClassOf,
            'select'=>$this->select,
            'join'=>$this->join,
            'where'=>$this->where,
            'execute'=>$this->execute,
            'paginate'=>$this->page,
            'orderBy'=>$this->order,
            'groupBy'=>$this->groupBy,
            'bool'=>$this->bool,
            'whereIn'=>$this->whereIn,
            'whereNotIn'=>$this->whereNotIn,
            'max'=>$this->max,
            'min'=>$this->min,
            'all'=>$this->all,
            'setField'=>$this->setField,
            'substring'=>$this->substring
        ];
    }

    /**
     * allmethodprocess method is main method.
     *
     * @return array
     */
    private function allMethodProcess($callback,$clean=null){
        if($clean!=="no--autoscope"){
            $this->autoScope=$this->getAutoScope();
        }

        $this->select=$this->selectBuilderOperation->selectMainProcess($this->select,$this->SqlPrepareFormatterHandleObject());
        $this->join=$this->joinBuilderOperation->joinMainProcess($this->join,$this->SqlPrepareFormatterHandleObject());
        $whereOperation=$this->whereBuilderOperation->whereMainProcess($this->where,$this->SqlPrepareFormatterHandleObject());
        $this->where=$whereOperation->where;
        $this->execute=[];
        if(property_exists($whereOperation,'execute')){
            $this->execute=$whereOperation->execute;
        }

        return call_user_func($callback);
    }

    /**
     * scope method is main method.
     *
     * @return array
     */
    public function scope($data=null,$model=null){
        if($this->model==null){
            $this->model=$model;
        }
        $model=$this->model;
        if(is_array($data) && count($data)){
            $static=$model->subClassOf;
            $scopedata=(is_array($data[0])) ? $data[0] : $data;
            foreach($scopedata as $value){
                $static->modelScope($value,$model::initial([]));
            }
        }
        else{
            $static=$model->subClassOf;
            $scopedata=[$data];
            foreach($scopedata as $value){
                $static->modelScope($value,$model::initial([]));
            }
        }

        return $this;


    }

    /**
     * scope method is main method.
     *
     * @return array
     */
    private function getAutoScope(){
        $model=$this->model;
        $static=$this->model->subClassOf;
        if(property_exists($static,"scope") && array_key_exists("auto",$static->scope)){
            $this->autoScope=$static->scope['auto'];
        }
        if($this->autoScope!==null && !is_array($this->autoScope)){
            $this->autoScope=[$this->autoScope];
        }

        $this->scope($this->autoScope,$model);

    }

    /**
     * create method is main method.
     *
     * @return array
     */
    public function create($data,$model=null){
        if($this->model==null){
            $this->model=$model;
        }
        if(is_array($data) && count($data)){
            $data=(array_key_exists(0,$data)) ? $data[0] : $data;
            return $this->querySqlFormatter->getInsertQueryFormatter($data,['model'=>$this->model->subClassOf,'bool'=>$this->bool,'transaction'=>$this->transaction,'transactionName'=>$this->transactionName]);
        }

    }

    /**
     * update method is main method.
     *
     * @return array
     */
    public function update($data,$model=false){

        if(is_array($data)){
            $data=(array_key_exists(0,$data)) ? $data[0] : $data;
            return $this->allMethodProcess(function() use($data,$model){
                return $this->querySqlFormatter->getUpdateQueryFormatter($data,['where'=>$this->where,'execute'=>$this->execute,
                    'model'=>$this->subClassOf,'bool'=>$this->bool,'detail'=>$model]);
            },"no--autoscope");

        }

    }


    /**
     * delete method is main method.
     *
     * @return array
     */
    public function delete($data=null,$model=null){
        if($this->model==null){
            $this->model=$model;
        }

        return $this->allMethodProcess(function() use($data){
            return $this->querySqlFormatter->getDeleteQueryFormatter([],['where'=>$this->where,'execute'=>$this->execute,'model'=>$this->subClassOf]);
        },"no--autoscope");

    }

    /**
     * save method is main method.
     *
     * @return string
     */
    public function transaction($callback=null,$model=null){
        if($this->model==null){
            $this->model=$model;
        }

        if(array_key_exists(0,$callback) && is_callable($callback[0])){
            $queries=call_user_func($callback[0]);
            return $this->querySqlFormatter->getTransactionProcess($queries);
        }
        $this->transaction=true;
        $this->transactionName=$callback[0];
        return $this;
    }


}