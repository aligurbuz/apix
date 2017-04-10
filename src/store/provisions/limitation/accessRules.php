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

namespace src\store\provisions\limitation;
use src\store\services\httprequest as request;

/**
 * Represents a access rules class.
 *
 * main call
 * return type boolean
 */

class accessRules {

    public static $status=true;

    /**
     * general limitations for every service.
     * if it is true status,run handle
     *
     * @return array
     */
    public static function handle(){

        //access rules
        return [

            'restrictions'=>[
                'ip::192.168.33.1'=>[
                    'throttle'=>'60:5',
                    'request'=>'all' //all|one
                ]
            ]
        ];
    }



}
