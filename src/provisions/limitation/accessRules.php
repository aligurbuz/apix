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

namespace src\provisions\limitation;
use src\services\httprequest as request;

/**
 * Represents a access rules class.
 *
 * main call
 * return type boolean
 */

class accessRules {

    public static $status=false;

    /**
     * general limitations for every service.
     * if it is true status,run handle
     *
     * @return array
     */
    public static function handle(){

        //access rules
        $rules=[];
        $rules['token']='all';
        $rules['ip']='all';
        $rules['throttle']='none';
        $rules['requestType']='all'; //all|one

        return $rules;
    }



}
