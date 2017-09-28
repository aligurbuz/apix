<?php

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

        //destroy if there is auth session
        //then,set register process
        $this->getAuthRegisterModel('destroy');

        /**
         * @var $this->getAuthDriverModel
         * get driver and model query
         */
        $this->getAuthDriverModel($credentials,'attempt');

        return $this->result;

    }


    /**
     * @method check
     * @return null
     */
    public function check(){

        /**
         * @var $this->getAuthDriverModel
         * get driver and model query
         */
        $this->getAuthDriverModel([],'check');

        return $this->result;

    }

    /**
     * @method persistent
     * @return null
     */
    public function persistent(){

        /**
         * @var $this->getAuthDriverModel
         * get driver and model query
         */
        $this->getAuthDriverModel([],'persistent');

        return $this->result;

    }


    /**
     * @method user
     * @return object
     */
    public function user(){

        //take data
        $this->check();

        //check returned query
        if(isset($this->query['results'])){

            //get user information as object
            return (object)$this->query['results'][0];
        }

        return null;


    }




}
