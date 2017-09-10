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
use Src\Store\Services\Httprequest as Request;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class joinBuilderOperation {


    private $querySqlFormatter;

    /**
     * getConstruct method is main method.
     *
     * @param querySqlFormatter $querySqlFormatter
     */
    public function __construct(querySqlFormatter $querySqlFormatter){
        $this->querySqlFormatter=$querySqlFormatter;
    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    public function joinMainProcess($data,$model){

        $joinerModel=$model['model']->joiner;

        $joinerArray=[];

       if(!isset($data['joiner'])){
           $data=$this->callWithModel($joinerModel);
       }

        if(array_key_exists('joiner',$data)){

            foreach ($data['joiner'][0] as $myJoin) {
                
                $myJoinBuilder="\\src\\app\\".app."\\".version."\\model\\sudb\\".$myJoin."";
                $myJoinClass=new $myJoinBuilder();
                $myJoinTable=$myJoinClass->table;
                
                foreach ($joinerModel[$myJoin]['relations'] as $key => $value) {
                    $joinerArray['join'][] = strtoupper($data['type']) . ' JOIN ' . $myJoinTable . ' ON ' . $model['model']->table . '.' . $key . '=' . $myJoinTable . '.' . $value;
                }

                if (array_key_exists("select",$data) && array_key_exists($myJoin, $data['select'])) {

                    foreach ($data['select'][$myJoin] as $selectVal) {
                        $joinerArray['select'][] = $myJoinTable . '.' . $selectVal;
                    }
                } else {
                    $joinerArray['select'][] =null;
                }

            }
        }


        return $joinerArray;

    }


    /**
     * @param $data
     * @return array
     */
    public function callWithModel($data){

        $callWithModelArray=[];
        foreach ($data as $model=>$value){
            $callWithModelArray=($value['auto']) ? $this->callWithModelArray($model,$value) : $this->sparseFieldsModelJoin($data);
        }
        return $callWithModelArray;
    }

    /**
     * @param $data
     * @return array
     */
    public function sparseFieldsModelJoin($data){

        $queryString=(new Request())->getQueryString();
        $callWithModelArray=[];

        if(isset($queryString['relations'])){

            $models=explode("-",$queryString['relations']);

            foreach ($data as $model=>$value){

                if(in_array($model,$models)){
                    $callWithModelArray=$this->callWithModelArray($model,$value);
                }

            }

        }

        return $callWithModelArray;


    }


    /**
     * @param $model
     * @param $value
     * @return array
     */
    private function callWithModelArray($model, $value){

        $callWithModelArray=[];
        $callWithModelArray['joiner'][0][]=$model;
        $callWithModelArray['joiner'][1][$model]=$value['fields'];
        $callWithModelArray['type']=$value['join'];
        $callWithModelArray['select'][$model]=$value['fields'];

        return $callWithModelArray;
    }


}