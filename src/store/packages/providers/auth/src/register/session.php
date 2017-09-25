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

class session extends Config {

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

        //check session
        if(!$this->session->has('auth')){

            //get hash for auth
            $authHash=$this->getAuthHash($this->config);

            //session register for authHash
            $this->session->set('auth',$authHash);
        }

        //query result
        $this->config->query=[
            'authToken'=>$this->session->get('auth')
        ];
    }



}
