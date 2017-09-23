<?php
/*
 * This is the official PHP client for Elasticsearch. It is designed to be a very low-level client that does not stray from the REST API.
 * All methods closely match the REST API, and furthermore, match the method structure of other language clients (ruby, python, etc).
 * We hope that this consistency makes it easy to get started with a client, and to seamlessly switch from one language to the next with minimal effort.
 * The client is designed to be "unopinionated". There are a few universal niceties added to the client (cluster state sniffing,
 * round-robin requests, etc) but largely it is very barebones. This was intentional. We want a common base that more sophisticated libraries can build on top of.
 */

namespace src\store\packages\providers\auth\src\register;

use src\store\services\httprequest as Request;

/**
 * Represents a authenticate class.
 *
 * main call
 * return type string
 */

abstract class config {

    /**
     * @var $dataForHash
     */
    public $dataForHash=array();

    /**
     * @param $config
     * @return string
     */
    public function getAuthHash($config){

        //push to array auth credentials
        //push to array auth client ip
        //push to array auth client http browser info
        $this->dataForHash              =$config->getCredentials();
        $this->dataForHash['ip']        =(new Request())->getClientIp();
        $this->dataForHash['agent']     =$_SERVER['HTTP_USER_AGENT'];

        //set hash for dataForHash
        //it hashes md5 and sha1
        return md5(sha1(implode(',',$this->dataForHash)));

    }

}
