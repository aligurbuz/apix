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
use src\store\services\httprequest as request;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class selectBuilderOperation {


    private $querySqlFormatter;
    public $request;

    /**
     * getConstruct method is main method.
     *
     * @return array
     */
    public function __construct(querySqlFormatter $querySqlFormatter,request $request){
        $this->querySqlFormatter=$querySqlFormatter;
        $this->request=$request;
    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    public function selectMainProcess($selectData,$model){

        $selectData=$this->getSelectHiddenFields($selectData,$model);
        $selectData=$this->getSelectPermissions($selectData,$model);
        $selectData=$this->setFieldOperation($selectData,$model);
        return $this->selectImplodeProcess($selectData);
    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    private function getSelectHiddenFields($selectData,$model){

        if(is_array($selectData)){
            return $this->getSelectDataValueList($selectData,$model);
        }
        else{
            $extra=null;
            if($model['substring']!==null && is_array($model['substring'])){
                $extra='substring';
            }
            $columns=$this->getSelectTableColumns($model,$extra);

            return $this->getSelectDataValueList($columns['field'],$model);
        }

    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    private function setFieldOperation($selectData,$model){

        if($model['setField']!==null && is_array($model['setField'])){
            foreach($model['setField'] as $key=>$value){
                if(is_array($value)){
                    if(array_key_exists(0,$model['setField'][$key]) AND array_key_exists(1,$model['setField'][$key])){
                        $varZero=explode("@",$model['setField'][$key][0]);
                        $joinInfo=explode(".",$varZero[1]);
                        $selectData[]='(select '.implode(",",$model['setField'][$key][1]).' from '.$joinInfo[0].' where '.$varZero[1].'='.$varZero[0].') as '.$key.'';
                    }
                }


            }
        }

        if($model['substring']!==null && is_array($model['substring'])){
            $joined=explode(".",$model['substring'][0]);
            $selectData[]='(select group_concat('.$model['substring'][1].') from '.$joined[0].' where
            substring_index('.$model['substring'][0].',"'.$model['substring'][2].'",'.$model['substring'][3].')) as '.$model['substring'][1].'';
        }


        return $selectData;

    }


    /**
     * getSelect method is main method.
     *
     * @return array
     */
    private function substringOperation($selectData,$model){

        if($model['substring']!==null && is_array($model['substring'])){
            $joined=explode(".",$model['substring'][0]);
            $selectData[]='(select group_concat('.$model['substring'][1].') from '.$joined[0].' where
            substring_index('.$model['substring'][0].',"'.$model['substring'][2].'",'.$model['substring'][3].')) as '.$model['substring'][1].'';
        }

        return $selectData;

    }


    /**
     * getSelect Permissions method is main method.
     *
     * @return array
     */
    private function getSelectPermissions($selectData,$model){
        $reeldata=$selectData;
        if(property_exists($model['model'],"selectPermissions")){
            $selectPermissions=$model['model']->selectPermissions;
            if($selectPermissions['status']){
                $headers=$this->request->getHeaders();
                if($selectPermissions['authorized']=="*"){
                    if(array_key_exists("select",$headers) && \app::checkToken()){
                        if($selectPermissions['tokens']=='*'){
                            $selectData=explode($selectPermissions['seperator'],$headers['select'][0]);
                            $list=[];
                            foreach($selectData as $key=>$value){
                                if(!in_array($value,$selectPermissions['forbidden'])){
                                    $list[$key]=$value;
                                }
                            }
                            $selectData=$list;
                        }

                        if(is_array($selectPermissions['tokens'])){
                            if(in_array($this->request->getQueryString()['_token'],$selectPermissions['tokens'])){
                                $selectData=explode($selectPermissions['seperator'],$headers['select'][0]);
                                $list=[];
                                foreach($selectData as $key=>$value){
                                    if(!in_array($value,$selectPermissions['forbidden'])){
                                        $list[$key]=$value;
                                    }
                                }
                                $selectData=$list;
                            }
                        }

                        $rlist=[];
                        foreach($selectData as $lkey=>$lvalue){
                            if(in_array($lvalue,$reeldata)){
                                $rlist[$lkey]=$lvalue;
                            }
                        }

                        if(count($rlist)){
                            $selectData=$rlist;
                        }
                        else{
                            $selectData=$reeldata;
                        }

                    }
                }

                if(is_array($selectPermissions['authorized'])){
                    if(array_key_exists("select",$headers) && \app::checkToken()){
                        if($selectPermissions['tokens']=='*'){
                            $selectData=explode($selectPermissions['seperator'],$headers['select'][0]);
                            $list=[];
                            foreach($selectData as $key=>$value){
                                if(in_array($value,$selectPermissions['authorized'])){
                                    $list[$key]=$value;
                                }
                            }
                            $listforbidden=[];
                            foreach($list as $key=>$value){
                                if(!in_array($value,$selectPermissions['forbidden'])){
                                    $listforbidden[$key]=$value;
                                }
                            }
                            $selectData=$listforbidden;
                        }

                        if(is_array($selectPermissions['tokens'])){
                            if(in_array($this->request->getQueryString()['_token'],$selectPermissions['tokens'])){
                                $selectData=explode($selectPermissions['seperator'],$headers['select'][0]);
                                $list=[];
                                foreach($selectData as $key=>$value){
                                    if(in_array($value,$selectPermissions['authorized'])){
                                        $list[$key]=$value;
                                    }
                                }
                                $listforbidden=[];
                                foreach($list as $key=>$value){
                                    if(!in_array($value,$selectPermissions['forbidden'])){
                                        $listforbidden[$key]=$value;
                                    }
                                }
                                $selectData=$listforbidden;
                            }

                        }


                        $rlist=[];
                        foreach($selectData as $lkey=>$lvalue){
                            if(in_array($lvalue,$reeldata)){
                                $rlist[$lkey]=$lvalue;
                            }
                        }

                        if(count($rlist)){
                            $selectData=$rlist;
                        }
                        else{
                            $selectData=$reeldata;
                        }


                    }
                }
            }
        }

        return $selectData;
    }

    /**
     * getSelectDataValueList method is main method.
     *
     * @return array
     */
    public function getSelectDataValueList($data,$model){
        $selectDataValueList=[];
        $selectDataValueBool=false;
        if(property_exists($model['model'],"selectHidden")){
            $selectDataValueBool=($data==$model['model']->selectHidden);
            if(count($model['model']->selectHidden)>count($data)){
                $selectDataValueBool=true;
            }
        }
        foreach($data as $selectDataValue){
            if(property_exists($model['model'],"selectHidden") && !in_array($selectDataValue,$model['model']->selectHidden)){
                $selectDataValueList[]=$selectDataValue;
            }
        }

        if(count($selectDataValueList) OR $selectDataValueBool===true){
            return $selectDataValueList;
        }
        return $data;

    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    private function getSelectTableColumns($model,$extra=null){

        return $this->querySqlFormatter->getModelTableShowColumns($this->subClassoF($model)->table,null);

    }

    /**
     * getSubClassOf method is main method.
     *
     * @return array
     */
    private function subClassoF($model){
        return $model['model'];
    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    private function selectImplodeProcess($selectData){
        return implode(",",$selectData);
    }

}