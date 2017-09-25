<?php
/*
 * This is the official PHP client for Elasticsearch. It is designed to be a very low-level client that does not stray from the REST API.
 * All methods closely match the REST API, and furthermore, match the method structure of other language clients (ruby, python, etc).
 * We hope that this consistency makes it easy to get started with a client, and to seamlessly switch from one language to the next with minimal effort.
 * The client is designed to be "unopinionated". There are a few universal niceties added to the client (cluster state sniffing,
 * round-robin requests, etc) but largely it is very barebones. This was intentional. We want a common base that more sophisticated libraries can build on top of.
 */

namespace src\store\packages\providers\auth\src\driver;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

class database {

    /**
     * @var $config \src\store\packages\providers\auth\src\config
     */
    public $config;


    /**
     * database constructor.
     * @param $config
     */
    public function __construct($config) {

        $this->config=$config;
    }

    /**
     * @param array $credentials
     * @return null
     */
    public function attempt($credentials=array()){

        //$credentials is array true and must be password
        if(count($this->config->credentials=$credentials)){

            //config auth model properties
            $this->config->getAuthDriverBuilder();
        }

        //check login and if it is true
        //set register process
        $this->config->setAuthRegister();

    }

}
