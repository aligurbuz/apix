<?php

namespace src\store\packages\providers\auth\src\register;

use src\store\services\httprequest as Request;
use src\store\packages\providers\auth\src\register\config as Config;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

class redis extends Config {

    /**
     * @var $config \src\store\packages\providers\auth\src\config
     */
    public $config;

    /**
     * @var $data
     */
    public $data;

    /**
     * @var $session \src\store\services\httpSession
     */
    public $session;


    /**
     * database constructor.
     * @param $config
     */
    public function __construct($config) {

        $this->config       =$config;
        $this->data         =$this->config->query['results'][0];
        $this->session      =app('session');
    }

    /**
     * @method register
     */
    public function register(){

        //make something
    }



}
