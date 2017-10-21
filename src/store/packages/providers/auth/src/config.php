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
use src\store\packages\providers\database\sudb\src\utils;
use src\store\services\httprequest as Request;

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
     * @var $pureQuery
     */
    public $pureQuery;

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
     * @var $token
     */
    public $token;

    /**
     * @var $data
     * get auth data
     */
    public $data;

    /**
     * @var $credentials
     */
    public $credentials;

    /**
     * @var $result
     */
    public $result=false;

    /**
     * @var authClass
     */
    public $authClass;

    /**
     * @var $request
     */
    public $request;

    /**
     * @var $persistent
     */
    public $persistent=null;


    /**
     * authenticate construct.
     *
     */
    public function __construct(){

        //get Auth List
        $this->auth=$this->getAuthList();
        $this->request=new Request();
    }

    /**
     * @return mixed|null|string
     */
    public function getAuthList(){

        //get config/auth as array
        $authConfigClass=StaticPathModel::getConfigStaticApp('auth');
        $this->authClass=utils::resolve($authConfigClass);

        //auth handle return
        return $this->authClass->handle();
    }

    /**
     * @return mixed
     */
    public function getModel(){

        //get model
        return $this->auth['provides'][$this->guard]['model'];
    }

    /**
     * @return mixed
     */
    public function getOrm(){

        //model parse array with explode
        $modelParseArray=explode("\\",$this->getModel());

        //Pop the element off the end of array
        array_pop($modelParseArray);

        //get orm as standard
        return end($modelParseArray);
    }

    /**
     * @return mixed
     */
    public function getDriver(){

        //get driver
        return $this->auth['provides'][$this->guard]['driver'];
    }

    /**
     * @return mixed
     */
    public function getCredentials(){

        //get user credentials
        return $this->auth['provides'][$this->guard]['credentials'];
    }

    /**
     * @return mixed
     */
    public function getEncrypt(){

        //get user credentials
        return $this->auth['provides'][$this->guard]['encrypt'];
    }

    /**
     * @return mixed
     */
    public function getPersistent(){

        //get user credentials
        return $this->auth['provides'][$this->guard]['persistent'];
    }


    /**
     * @return mixed
     */
    public function getPersistentKey(){

        //get user credentials
        return $this->auth['provides'][$this->guard]['persistentKey'];
    }

    /**
     * @return mixed
     */
    public function getTokenField(){

        //get token field
        return $this->auth['provides'][$this->guard]['tokenField'];
    }

    /**
     * @return mixed
     */
    public function getRegisterMethod(){

        //get register method
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
        return (new $driver($this))->$method($credentials);

    }


    /**
     * @param $method
     * @method getAuthRegisterModel
     * @return mixed
     */
    public function getAuthRegisterModel($method='register'){

        //register namespace
        //register files must be in register directory
        $driver=__NAMESPACE__.'\register\\'.$this->getRegisterMethod();

        //call class for driver
        //it is database or other [like redis]
        return (new $driver($this))->$method();

    }


    /**
     * @param $method
     * @param $param
     * @method getAuthEncryptModel
     * @return mixed
     */
    public function getAuthEncryptModel($method='register',$param=null){

        //encrypt namespace
        //register files must be in encrypt directory
        $driver=__NAMESPACE__.'\encrypt\\'.$this->getEncrypt();

        //call class for driver
        //it is database or other [like redis]
        return (new $driver($this))->$method($param);

    }


    /**
     * @param string $method
     * @param $data null
     * @method getAuthDriverBuilder
     * @return mixed
     */
    public function getAuthDriverBuilder($method='attempt',$data=null){

        //builder namespace
        //register files must be in driver/builder directory
        $driver=__NAMESPACE__.'\builder\\'.$this->getOrm();

        //call class for driver
        //it is sudb as default  or other [like eloquent,doctrine]
        return (new $driver($this))->$method($data);

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


    /**
     * @param bool $status
     * @return bool|mixed
     */
    public function setAuthRegister($status=true){

        //if query variable contains error
        //directly output null
        if(isset($this->query['error'])){

            //query null
            return $this->result=false;
        }

        if($status){

            //set register driver
            return $this->getAuthRegisterModel();
        }

        //if query is not null
        if($this->query!==null) {

            //set result true
            return $this->result=true;
        }

        //result false
        return $this->result=false;

    }

    /**
     * @method getTokenPersistent
     * @return null
     */
    public function getTokenPersistent(){

        //get persistent
        $persistent=$this->getPersistent();

        //get persistent Key
        $persistentKey=$this->getPersistentKey();

        //get request headers
        $headers=$this->request->getHeaders();

        if($persistent=="header" && isset($headers[$persistentKey])){

            //get persistent auth
            if($headers[$persistentKey][0]!==null AND strlen(trim($headers[$persistentKey][0]))>0){

                return $headers[$persistentKey][0];
            }

        }

        return rand(1,999999);
    }

    /**
     * @method getCredentialsKey
     * @return array
     */
    public function getCredentialsKey(){

        //get array keys from credentials
        return array_keys($this->getCredentials());
    }

    /**
     * @param $token
     */
    public function getSecurityCredentials($token){

        $userData=$this->getAuthDriverBuilder('getSecurityDataForToken',$token);

        $credentials=[];

        foreach ($this->getCredentialsKey() as $credential){

            $credentials[$credential]=$userData['results'][0][$credential];
        }

       $this->credentials=$credentials;
    }




}
