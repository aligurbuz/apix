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

namespace src\app\testApp\v1\optional\provisions\limitation;

use Src\Store\Services\Httprequest as Request;

/**
 * Represents a access rules class.
 *
 * main call
 * return type boolean
 */

class accessRules
{

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
                    'throttle'=>'60:10',
                    'request'=>'all' //all|one
                ]
            ]
        ];
    }

}
