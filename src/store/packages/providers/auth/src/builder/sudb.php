<?php

namespace src\store\packages\providers\auth\src\builder;

use src\store\services\httprequest as Request;
use src\store\packages\providers\auth\src\register\config as Config;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

class sudb extends Config {

    /**
     * @var $config \src\store\packages\providers\auth\src\config
     */
    public $config;

    /**
     * @var $model
     */
    public $model;


    /**
     * database constructor.
     * @param $config
     */
    public function __construct($config) {

        $this->config       =$config;
        $this->model        =$this->config->getModel();
    }

    /**
     * @param $pure
     * @method register
     * @return mixed
     */
    public function attempt($pure=false){

        //get model
        $model=$this->model;

        /**
         * @var $credentials
         * get credentials
         */
        $credentials=$this->config->credentials;

        //pure model query
        //credentials coming from client
        $query=$model::where(function($query) use($credentials) {

            foreach ($credentials as $key=>$value){
                $query->where($key,'=',$value);
            }
        });

        //pure true
        if($pure){

            //get pure query
            //for update
            return $query;
        }

        //sudb orm query
        $this->config->query=$query->get();

    }

    /**
     * @method updateAppToken
     */
    public function updateAppToken(){

        //app token update
        $this->attempt(true)->update([$this->config->getTokenField()=>$this->config->token]);
    }


    /**
     * @method check
     * check auth from driver
     */
    public function check(){

        //get model
        $model=$this->model;

        //check register method for auth
        $auth=$this->config->getAuthRegisterModel('check');

        //check driver for auth
        if(count($auth)){

            //get query for auth id
            $this->config->query=$model::where(function($query) use($auth) {

                $query->where('id','=',$auth['authId']);
                $query->where($this->config->getTokenField(),'=',$auth['token']);

            })->get();

        }
    }



}
