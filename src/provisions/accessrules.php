<?php
/*
 * This file is provision rules of the every service.
 * it means access condition as minute,hour,time to service
 *
 * provision returns boolean value (true|false)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\provisions;
use src\services\httprequest as request;

/**
 * Represents a access rules class.
 *
 * main call
 * return type boolean
 */

class accessrules {

    public $request;
    public $status=false;

    /**
     * Represents a access rules construct class.
     *
     * $data main variables
     * return type string
     */
    public function __construct(request $request){

        $this->request=$request;
    }

    /**
     * start with project method name.
     *
     * @return boolean true|false
     */
    public function projectNameHere(){

        //access rules
        $rules=[];
        $rules['serviceName']='all';
        $rules['methodName']='all';
        $rules['token']='all';
        $rules['ip']='all';
        $rules['throttle']='60:20/none';
        $rules['request']='86400:100';
        $rules['requestType']='all'; //all|one

        return $rules;
    }



}
