<?php

namespace src\store\packages\providers\auth\src\register;

use src\store\services\httprequest as Request;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

abstract class config {

    /**
     * @var $dataForHash
     */
    protected $dataForHash=array();

    /**
     * @var $contextHash
     */
    public $contextHash= array();

    /**
     * @var $config
     */
     public $config;

    /**
     * @var $id
     */
    public $id;


    /**
     * @param $config
     * @return string
     */
    protected function getAuthHash($config){

        /**
         * @var $config \src\store\packages\providers\auth\src\config
         */
        $this->config=$config;

        /**
         * push to array auth credentials
         * push to array auth client ip
         * push to array auth client http browser info
         */
        $this->dataForHash              =$this->config->getCredentials();
        $this->dataForHash['ip']        =(new Request())->getClientIp();
        $this->dataForHash['agent']     =$_SERVER['HTTP_USER_AGENT'];

        //set context hash variable
        $this->contextHash=$this->dataForHash;
        $this->setContextHash('time',time());

        //id algorithm
        //it is for that we do not directly register auth id
        $this->setIdAlgorithm();

        //set hash for dataForHash
        //it hashes md5 and sha1
        return $this->getContextHash();

    }

    /**
     * @param $key
     * @param $value
     */
    protected function setContextHash($key, $value){

        //check context Hash
        //if it is empty,then set key value
        if(!isset($this->contextHash[$key])){

            $this->contextHash[$key]=$value;
        }

    }

    /**
     * @method getContextHash
     */
    protected function getContextHash(){

        return $this->id.'_'.md5(sha1(implode(',',$this->contextHash)));
    }

    /**
     * @method setIdAlgorithm
     */
    protected function setIdAlgorithm(){

        //set encrypt model for id
        $this->id=$this->config->getAuthEncryptModel();
    }

}
