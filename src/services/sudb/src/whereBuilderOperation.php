<?php
/*
 * This file is main part of the sudb.
 *
 * model is called for model file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services\sudb\src;
use \src\services\sudb\src\querySqlFormatter as querySqlFormatter;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class whereBuilderOperation {


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
    public function whereMainProcess($whereData,$model){
        $list['where']='';
        $list['execute']=[];
        if(count($whereData)){
            foreach ($whereData['field'] as $key=>$value){
                if($whereData['operator'][$key]=="LIKE"){
                    $list['where'][]=''.$value.' '.$whereData['operator'][$key].' :'.$value.'';
                    $list['execute'][':'.$value.'']='%'.$whereData['value'][$key].'%';
                }
                else{
                    if(preg_match('@^between_@is',$value)){
                        $value=str_replace("between_","",$value);
                        $list['where'][]=''.$value.' BETWEEN :'.$value.'_'.md5($whereData['operator'][$key]).' AND :'.$value.'_'.md5($whereData['value'][$key]).'';
                        $list['execute'][':'.$value.'_'.md5($whereData['operator'][$key]).'']=$whereData['operator'][$key];
                        $list['execute'][':'.$value.'_'.md5($whereData['value'][$key]).'']=$whereData['value'][$key];
                    }
                    elseif(preg_match('@^notbetween_@is',$value)){
                        $value=str_replace("notbetween_","",$value);
                        $list['where'][]=''.$value.'<:'.$value.'_'.md5($whereData['operator'][$key]).' OR '.$value.'>:'.$value.'_'.md5($whereData['value'][$key]).'';
                        $list['execute'][':'.$value.'_'.md5($whereData['operator'][$key]).'']=$whereData['operator'][$key];
                        $list['execute'][':'.$value.'_'.md5($whereData['value'][$key]).'']=$whereData['value'][$key];
                    }
                    elseif($value=="today"){
                        if(property_exists($model['model'],"createdAndUpdatedFields") && array_key_exists("created_at",$model['model']->createdAndUpdatedFields)){
                            $list['where'][]='FROM_UNIXTIME('.$model['model']->createdAndUpdatedFields['created_at'].',"%Y-%m-%d")="'.date("Y-m-d").'"';
                        }

                    }
                    else{
                        $list['where'][]=''.$value.''.$whereData['operator'][$key].':'.$value.'';
                        $list['execute'][':'.$value.'']=$whereData['value'][$key];
                    }

                }

            }

            if(is_array($list['where'])){
                $list['where']='WHERE '.implode(" AND ",$list['where']);
            }



        }

        return (object)$list;
    }


}