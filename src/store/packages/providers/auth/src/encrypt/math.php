<?php

namespace src\store\packages\providers\auth\src\encrypt;

use src\store\services\httprequest as Request;
use src\store\packages\providers\auth\src\register\config as Config;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

class math extends Config {

    /**
     * @var $config \src\store\packages\providers\auth\src\config
     */
    public $config;

    /**
     * @var $data
     */
    public $data;

    /**
     * @var $data_id
     */
    public $data_id;

    /**
     * @var $request \src\store\services\httprequest
     */
     public $request;


    /**
     * database constructor.
     * @param $config
     */
    public function __construct($config) {

        $this->config=$config;
        $this->data_id=$this->config->data['id'];
        $this->request=new Request();
    }

    /**
     * @method register
     */
    public function register(){

        return $this->data_id * \ip2long($this->request->getClientIp());
    }

    /**
     * @param $id
     * @method resolve
     * @return mixed
     */
    public function resolve($id){

        return $id / \ip2long($this->request->getClientIp());
    }


}
