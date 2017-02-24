<?php
/*
 * This file is client and browser info of the fussy service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;
use Predis\Client as client;

/**
 * Represents a redis class.
 *
 * main call
 * return type string
 */

class redis {

    public $client;

    /**
     * redis configuration.
     *
     * @return redis class
     */
    public function __construct(client $client){

        //redis client
        $this->client=$client;
    }


    /**
     * redis set data.
     *
     * @return redis class
     */
    public function set($data,$expire=null){

        //set return
        if($this->client->set($data[0],$data[1])){
            if($expire!==null && is_numeric($expire)){
                $this->expire($data[0],$expire);
                return true;
            }
            return true;
        }

        return false;

    }


    /**
     * redis get data.
     *
     * @return redis class
     */
    public function get($key=null){

        //get return
        if($key!==null){
            return $this->client->get($key);
        }

        return null;

    }

    /**
     * redis get data exists.
     *
     * @return redis class
     */
    public function exists($key){

        //get exists
        if($this->client->exists($key)){
            return true;
        }
        return false;
    }


    /**
     * redis get data expire.
     *
     * @return redis class
     */
    public function expire($key,$ttl){

        //get expire
        $this->client->expire($key,$ttl);
    }

    /**
     * delete all keys.
     *
     * @return redis class
     */
    public function flushdb(){

        //get flushdb
        $this->client->flushdb();
    }

    /**
     * delete specified keys.
     *
     * @return redis class
     */
    public function delete($keys=array()){

        //get delete
        if(is_array($keys) && count($keys)){
            return $this->client->del($keys);
        }
    }

    /**
     * get all keys.
     *
     * @return redis class
     */
    public function getAllKeys($pattern="*"){

        //get keys
        return $this->client->keys($pattern);
    }



}
