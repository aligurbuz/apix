<?php
/*
 * This is the official PHP client for Elasticsearch. It is designed to be a very low-level client that does not stray from the REST API.
 * All methods closely match the REST API, and furthermore, match the method structure of other language clients (ruby, python, etc).
 * We hope that this consistency makes it easy to get started with a client, and to seamlessly switch from one language to the next with minimal effort.
 * The client is designed to be "unopinionated". There are a few universal niceties added to the client (cluster state sniffing,
 * round-robin requests, etc) but largely it is very barebones. This was intentional. We want a common base that more sophisticated libraries can build on top of.
 */

namespace src\store\packages\providers\auth\src;

use Apix\StaticPathModel;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

class config {

    /**
     * @var $query
     * set model properties
     */
    public $query=null;

    /**
     * @var $guard
     */
    public $guard='default';


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

        return $this->auth['provides'][$this->guard]['model'];
    }

    /**
     * @return mixed
     */
    public function getDriver(){

        return $this->auth['provides'][$this->guard]['driver'];
    }

    /**
     * @return mixed
     */
    public function getCredentials(){

        return $this->auth['provides'][$this->guard]['credentials'];
    }

    /**
     * @return mixed
     */
    public function getRegisterMethod(){

        return $this->auth['provides'][$this->guard]['registerMethod'];
    }


    /**
     * @param array $credentials
     * @param null $method
     */
    public function getAuthDriverModel($credentials=array(), $method=null){

        //check credentials for configuration
        $credentials=$this->checkCredentials($credentials);

        //driver namespace
        //driver files must be in same directory
        $driver=__NAMESPACE__.'\driver\\'.$this->getDriver();


        //call class for driver
        //it is database or other [like redis]
        (new $driver($this))->$method($credentials);

    }


    /**
     * @method getAuthRegisterModel
     */
    public function getAuthRegisterModel(){

        //register namespace
        //register files must be in register directory
        $driver=__NAMESPACE__.'\register\\'.$this->getRegisterMethod();

        //call class for driver
        //it is database or other [like redis]
        (new $driver($this))->register();

    }


    /**
     * @param array $credentials
     * @return array|mixed
     */
    public function checkCredentials($credentials=array()){

        //if credential array is sent as isset
        //it is assigned as normal
        //if credential array is sent as empty
        //it is assigned as credentials that in config/auth
        return (count($credentials)) ? $credentials : $this->getCredentials();

    }


    public function setAuthRegister(){

        //if query variable contains error
        //directly output null
        if(isset($this->query['error'])){
            return $this->query=null;
        }

        //set register driver
        $this->getAuthRegisterModel();

    }

}
