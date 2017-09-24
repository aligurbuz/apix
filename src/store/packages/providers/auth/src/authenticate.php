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

        /**
         * @var $this->getAuthDriverModel
         * get driver and model query
         */
        $this->getAuthDriverModel($credentials,'attempt');

        return $this->query;

    }




}
