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
use \src\services\sudb\querySqlFormatter as querySqlFormatter;
use \src\services\sudb\selectBuilderOperation as selectBuilderOperation;
use \src\services\sudb\whereBuilderOperation as whereBuilderOperation;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class builder {


    private $model=null;
    private $select="*";
    private $find=null;
    private $where=[];
    private $page=0;
    private $order=null;
    private $execute=[];
    private $querySqlFormatter;
    private $selectBuilderOperation;
    private $whereBuilderOperation;
    private $subClassOf=null;
    private $autoScope=null;

    private static $primarykey_static=null;
    private static $modelscope=null;
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
    private static $joiner='';
    private static $whereIn=null;
    private static $whereNotIn=null;
    private static $orWhere=[];
    private static $whereColumn=[];
    private static $whereYear=[];
    private static $whereMonth=[];
    private static $whereDay=[];
    private static $whereDate=[];
    private static $addToSelectSql=null;
    private static $having=[];

    public function __construct(querySqlFormatter $querySqlFormatter,selectBuilderOperation $selectBuilderOperation,whereBuilderOperation $whereBuilderOperation){
        $this->querySqlFormatter=$querySqlFormatter;
        $this->selectBuilderOperation=$selectBuilderOperation;
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
     * select method is main method.
     *
     * @return array
     */
    public function select($select=null,$model){
        $this->model=$model;
        if(is_array($select) && array_key_exists(0,$select)){
            $this->select=$select[0];
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
                $this->where['value'][]=$value;
            }

        }

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

            $this->order=['key'=>$key[0],'order'=>$key[1]];
        }
        else{
            $this->order=['key'=>$key,'order'=>$order];
        }
        return $this;

    }

    /**
     * paginate method is main method.
     *
     * @return array
     */
    public function paginate($paginate=null){
        if(is_numeric($paginate[0])){
            $this->page=$paginate[0];
        }

        return $this;
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

            if($result['paginator']>0){
                $lastpage=(int)$result['getCountAllTotal']/(int)$result['paginator'];
                return [
                    'CountAllData'=>(int)$result['getCountAllTotal'],
                    'paginator'=>(int)$result['paginator'],
                    'currentPage'=>(int)$result['currentPage'],
                    'lastPage'=>(int)ceil($lastpage),
                    'data'=>$this->getColumnsType($result['result'],$result['columns'],$result['fields'])
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
    private function queryFormatter(){
        return $this->querySqlFormatter->getSqlPrepareFormatter($this->SqlPrepareFormatterHandleObject());
    }

    /**
     * get columns type is main method.
     *
     * @return array
     */
    private function getColumnsType($data,$types,$fields){
        $list=[];
        if($fields!==null){
            foreach ($fields as $key=>$value) {
                foreach($data as $dkey=>$dvalue){
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
            }
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
            'where'=>$this->where,
            'execute'=>$this->execute,
            'paginate'=>$this->page,
            'orderBy'=>$this->order
        ];
    }

    /**
     * allmethodprocess method is main method.
     *
     * @return array
     */
    private function allMethodProcess($callback){
        $this->autoScope=$this->getAutoScope();
        $this->select=$this->selectBuilderOperation->selectMainProcess($this->select,$this->SqlPrepareFormatterHandleObject());
        $whereOperation=$this->whereBuilderOperation->whereMainProcess($this->where,$this->SqlPrepareFormatterHandleObject());
        $this->where=$whereOperation->where;
        $this->execute=$whereOperation->execute;
        return call_user_func($callback);
    }

    /**
     * scope method is main method.
     *
     * @return array
     */
    public function scope($data=null,$model=null){
        if(is_array($data)){
            if($this->model==null){
                $this->model=$model;
                $model=$this->model;
            }
            $static=$model->subClassOf;
            $scopedata=(is_array($data[0])) ? $data[0] : $data;
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
     * select method is main method.
     *
     * @return array
     */
    public function create($data){
        if(request=="POST"){
            if(is_array($data) && count($data)){
                return $this->querySqlFormatter->getInsertQueryFormatter($data[0],$this->subClassOf);
            }
        }

        return [
            'error'=>true,
            'message'=>'You have to use post method for insert',
        ];

    }


}