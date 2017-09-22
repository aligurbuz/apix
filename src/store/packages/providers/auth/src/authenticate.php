<?php
/*
 * This is the official PHP client for Elasticsearch. It is designed to be a very low-level client that does not stray from the REST API.
 * All methods closely match the REST API, and furthermore, match the method structure of other language clients (ruby, python, etc).
 * We hope that this consistency makes it easy to get started with a client, and to seamlessly switch from one language to the next with minimal effort.
 * The client is designed to be "unopinionated". There are a few universal niceties added to the client (cluster state sniffing,
 * round-robin requests, etc) but largely it is very barebones. This was intentional. We want a common base that more sophisticated libraries can build on top of.
 */

namespace src\store\packages\providers\auth\src;

use Src\Store\Packages\Providers\Auth\Src\Config;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

class authenticate extends Config {

    public $query;

    /**
     * authenticate construct.
     *
     */
    public function __construct(){

        $this->auth=$this->getAuthList();
    }


    /**
     * @param $credentials
     * @return mixed
     */
    public function getAuthModelQuery($credentials=array()){

        /**
         * @var $model
         * get authenticate model
         */
        $model=$this->getModel();

        //$credentials is array true and must be password
        if(count($credentials) AND isset($credentials['password'])){

            //config auth model properties
            $this->query=$model::where(function($query) use($credentials) {

                foreach ($credentials as $key=>$value){
                    $query->where($key,'=',$value);
                }
            })->get();
        }

        return null;

    }


    /**
     * @param array $credentials
     * @return mixed|null|string
     */
    public function attempt($credentials=array()){

        /**
         * @var $authModelQuery
         * we run model query for auth
         */
        $this->getAuthModelQuery($credentials);

        return $this->query;

    }




}
