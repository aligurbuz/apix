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

        $this->config               =$config;
        $this->config->data         =$this->config->query['results'][0];
        $this->session              =app('session');
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

            //app token update
            $this->config->token=$this->session->get('auth');
            $this->config->getAuthDriverModel([],'updateAppToken');

        }

        //query result
        $this->config->result=[
            'authToken'=>$this->session->get('auth')
        ];
    }

    /**
     * @method check
     * @return array
     */
    public function check(){

        if($this->session->has('auth')){

            $authExplode=$this->sessionAuthParse();

            //get auth information
            $authId=$this->config->getAuthEncryptModel('resolve',(int)$authExplode[0]);
            $authData=$authExplode[1];
            $token=$this->session->get('auth');

            //return compact for array
            return compact('authId','authData','token');
        }

        return [];
    }


    /**
     * @method destroy
     * auth destroy
     */
    public function destroy(){

        if($this->session->has('auth')){

            //session auth destroy
            $this->session->remove('auth');
        }

    }

    /**
     * @method sessionAuthParse
     */
    private function sessionAuthParse(){

        //session auth parse
        return explode('_',$this->session->get('auth'));

    }



}
