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

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class builder {


    private $select="*";
    private $find=null;
    private $where=[];
    private $execute=[];
    private $querySqlFormatter;
    private $selectBuilderOperation;
    private $subClassOf=null;

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
    private static $whereMonth=[];
    private static $whereDay=[];
    private static $whereDate=[];
    private static $addToSelectSql=null;
    private static $having=[];

    public function __construct(querySqlFormatter $querySqlFormatter,selectBuilderOperation $selectBuilderOperation){
        $this->querySqlFormatter=$querySqlFormatter;
        $this->selectBuilderOperation=$selectBuilderOperation;
    }

    /**
     * select method is main method.
     *
     * @return array
     */
    public function select($select=null){
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
    public function where(){
        return $this;
    }

    /**
     * get method is main method.
     *
     * @return array
     */
    public function get(){
        return $this->allMethodProcess(function(){
            return ['data'=>$this->queryFormatter()];
        });

    }

    /**
     * get method is main method.
     *
     * @return array
     */
    public function queryFormatter(){
        return $this->querySqlFormatter->getSqlPrepareFormatter($this->SqlPrepareFormatterHandleObject());
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
    public function SqlPrepareFormatterHandleObject(){
        return [
            'model'=>$this->subClassOf,
            'select'=>$this->select
        ];
    }

    /**
     * allmethodprocess method is main method.
     *
     * @return array
     */
    private function allMethodProcess($callback){
        $this->select=$this->selectBuilderOperation->selectMainProcess($this->select,$this->SqlPrepareFormatterHandleObject());
        return call_user_func($callback);
    }
}