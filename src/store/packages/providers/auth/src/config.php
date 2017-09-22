<?php
/*
 * This is the official PHP client for Elasticsearch. It is designed to be a very low-level client that does not stray from the REST API.
 * All methods closely match the REST API, and furthermore, match the method structure of other language clients (ruby, python, etc).
 * We hope that this consistency makes it easy to get started with a client, and to seamlessly switch from one language to the next with minimal effort.
 * The client is designed to be "unopinionated". There are a few universal niceties added to the client (cluster state sniffing,
 * round-robin requests, etc) but largely it is very barebones. This was intentional. We want a common base that more sophisticated libraries can build on top of.
 */

namespace src\store\packages\providers\auth\src;

use Apix\Utils;
use Apix\StaticPathModel;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

class config {

    //traits
    use databaseDriver;

    /**
     * @var $query
     * set model properties
     */
    public $query;


    /**
     * @var $auth
     * global auth variable
     */
    public $auth;

    /**
     * authenticate construct.
     *
     */
    public function __construct(){

        $this->auth=$this->getAuthList();
    }

    /**
     * @return mixed|null|string
     */
    public function getAuthList(){

        return StaticPathModel::getConfigStaticApp('auth','array');
    }

    /**
     * @return mixed
     */
    public function getModel(){

        return $this->auth['provides']['model'];
    }

    /**
     * @return mixed
     */
    public function getDriver(){

        return $this->auth['provides']['driver'];
    }

    /**
     * @param array $credentials
     */
    public function getAuthDriverModel($credentials=array()){

        //get method name for driver
        //it is database or other [like redis]
        $driverMethod='getAuth'.$this->getDriver().'Query';

        //get driver query properties
        $this->$driverMethod($credentials);

    }

}
