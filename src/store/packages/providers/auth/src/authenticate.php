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


    /**
     * @param null $guard
     * @return $this
     */
    public function guard($guard=null){

        //if guard variable is null,config guard is assigned it
        //if it is not null, config guard
        $this->guard=($guard===null) ? $this->guard: $guard;

        return $this;
    }

    /**
     * @param array $credentials
     * @return mixed|null|string
     * login post attempt
     */
    public function attempt($credentials=array()){

        /**
         * @var $credentials
         * check credentials for configuration
         */
        $credentials=$this->checkCredentials($credentials);

        /**
         * @var $getAuthDriverModel
         * get driver and model query
         */
        $this->getAuthDriverModel($credentials);

        return $this->query;

    }




}
