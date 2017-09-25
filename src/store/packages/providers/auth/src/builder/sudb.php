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
     * database constructor.
     * @param $config
     */
    public function __construct($config) {

        $this->config       =$config;
    }

    /**
     * @method register
     */
    public function query(){

        /**
         * @var $model
         * get authenticate model
         */
        $model=$this->config->getModel();

        /**
         * @var $credentials
         * get credentials
         */
        $credentials=$this->config->credentials;

        //sudb orm query
        $this->config->query=$model::where(function($query) use($credentials) {

            foreach ($credentials as $key=>$value){
                $query->where($key,'=',$value);
            }
        })->get();
    }



}
