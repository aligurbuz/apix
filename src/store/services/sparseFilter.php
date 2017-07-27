<?php
/*
 * This file is client and browser info of the fussy service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;

use Src\Store\Services\Httprequest as Request;

/**
 * Represents a redis class.
 *
 * main call
 * return type string
 */
class sparseFilter {

    /**
     * @var request
     */
    public $request;

    /**
     * Construct
     */
    public function __construct(){

        $this->request=new Request();
    }
    /**
     * @param $callback
     * @return string
     */
    public function filter($callback){

        //$call=call_user_func($callback);
        return [
            'key'=>'sparse'
        ];
    }

}
