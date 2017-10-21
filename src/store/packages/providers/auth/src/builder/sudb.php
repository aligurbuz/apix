<?php

namespace src\store\packages\providers\auth\src\builder;

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
        $this->config->query    =$query->get();

        if(isset($this->config->query['results'])){
            $this->config->data     =$this->config->query['results'][0];
        }

    }

    /**
     * @method updateAppToken
     */
    public function updateAppToken(){

        //app token update
        $this->attempt(true)->update([$this->config->getTokenField()=>$this->config->token]);
    }


    /**
     * @param $token
     * @return mixed
     */
    public function getSecurityDataForToken($token){

        //get model
        $model=$this->model;

        $query=$model::where($this->config->getTokenField(),'=',$token)->get();

        return $query;
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

        //check authId from session
        if(isset($auth['authId'])){

            //set config data id
            $this->config->data['id']=$auth['authId'];
        }

        //check driver for auth and auth math as real calculating via client ip
        if(isset($auth['authMath']) && $auth['authMath']==$this->config->getAuthEncryptModel()){

            //get query for auth id
            $this->config->query=$model::where(function($query) use($auth) {

                $query->where('id','=',$auth['authId']);
                $query->where($this->config->getTokenField(),'=',$auth['token']);

            })->get();

        }
    }


    /**
     * @method persistent
     * check auth from driver
     */
    public function persistent(){

        //get model
        $model=$this->model;

        //get query for auth id
        $persistentQuery=$model::where(function($query) {

            $query->where($this->config->getTokenField(),'=',$this->config->getTokenPersistent());

        })->get();

        if(!isset($persistentQuery['error'])){

            //persistent data
            $persistentData=$persistentQuery['results'][0];

            //call check method
            $this->check();

            //if query is null
            if($this->config->query===null){

                //set credentials
                $attemptCredentials=[];

                //config credentials key
                foreach ($this->config->getCredentialsKey() as $credent){

                    //set key credentials from config/auth
                    $attemptCredentials[$credent]=$persistentData[$credent];
                }

                //set config persistent get token field from driver
                $this->config->persistent=$persistentData[$this->config->getTokenField()];

                //set new auth credentials attempt
                $this->config->getAuthDriverModel($attemptCredentials,'attempt');
            }
        }


    }




}
