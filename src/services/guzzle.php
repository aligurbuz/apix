<?php
/*
 * This file is client and http request of the guzzle service.
 *
 * client and guzzle http request
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;
use GuzzleHttp\Client as Client;

/**
 * Represents a redis class.
 *
 * main call
 * return type string
 */

class guzzle {

    public $client;

    /**
     * redis configuration.
     *
     * @return redis class
     */
    public function __construct(){

        //redis client
        $this->client=new Client();
    }


    /**
     * redis set data.
     *
     * @return redis class
     */
    public function request($method=null,$url=null,$responseObject=null){
        //get response guzzle
        $response = $this->client->request($method,$url,[]);
        if($responseObject==null){
            return json_decode($response->getBody()->getContents(),1);
        }
    }

}
