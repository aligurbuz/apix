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

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class selectBuilderOperation {


    private $querySqlFormatter;

    /**
     * getConstruct method is main method.
     *
     * @return array
     */
    public function __construct(querySqlFormatter $querySqlFormatter){
        $this->querySqlFormatter=$querySqlFormatter;
    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    public function selectMainProcess($selectData,$model){
        $selectData=$this->getSelectHiddenFields($selectData,$model);
        return $this->selectImplodeProcess($selectData);
    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    private function getSelectHiddenFields($selectData,$model){
        if(is_array($selectData)){
            $selectDataValueList=[];
            foreach($selectData as $selectDataValue){
                if(!in_array($selectDataValue,$model['model']->selectHidden)){
                    $selectDataValueList[]=$selectDataValue;
                }
            }
            return $selectDataValueList;
        }
        else{
            $columns=$this->getSelectTableColumns($model);
            dd($columns['field']);
        }

    }

    /**
     * getSelect method is main method.
     *
     * @return array
     */
    private function getSelectTableColumns($model){
        return $this->querySqlFormatter->getModelTableShowColumns($this->subClassoF($model)->table);
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