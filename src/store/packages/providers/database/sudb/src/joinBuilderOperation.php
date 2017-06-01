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
        if(array_key_exists('joiner',$data)){
            foreach ($data['joiner'][0] as $myJoin) {
                foreach ($joinerModel[$myJoin] as $key => $value) {
                    $joinerArray['join'][] = strtoupper($data['type']) . ' JOIN ' . $myJoin . ' ON ' . $model['model']->table . '.' . $key . '=' . $myJoin . '.' . $value;
                }

                if (array_key_exists($myJoin, $data['select'])) {

                    foreach ($data['select'][$myJoin] as $selectVal) {
                        $joinerArray['select'][] = $myJoin . '.' . $selectVal;
                    }
                } else {
                    $joinerArray['select'][] = null;
                }

            }
        }



        return $joinerArray;

    }


}