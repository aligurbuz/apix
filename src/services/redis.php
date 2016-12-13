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
    public function set($data){

        //set return
        return $this->client->set($data[0],$data[1]);
    }


    /**
     * redis get data.
     *
     * @return redis class
     */
    public function get($key){

        //get return
        return $this->client->get($key);
    }


}
