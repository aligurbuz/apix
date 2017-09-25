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
     * database constructor.
     * @param $config
     */
    public function __construct($config) {

        $this->config=$config;
        $this->data_id=$this->config->data['id'];
    }

    /**
     * @method register
     */
    public function register(){

        return $this->data_id;
    }



}
