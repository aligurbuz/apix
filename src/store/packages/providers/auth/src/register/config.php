<?php

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

        /**
         * @var $config \src\store\packages\providers\auth\src\config
         * push to array auth credentials
         * push to array auth client ip
         * push to array auth client http browser info
         */
        $this->dataForHash              =$config->getCredentials();
        $this->dataForHash['ip']        =(new Request())->getClientIp();
        $this->dataForHash['agent']     =$_SERVER['HTTP_USER_AGENT'];

        //set hash for dataForHash
        //it hashes md5 and sha1
        return md5(sha1(implode(',',$this->dataForHash)));

    }

}
