<?php
/*
 * This file is provision of the every service.
 *
 * provision returns boolean value (true|false)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\testApp\v1\optional\provisions;

use Src\Store\Services\Httprequest as Request;

/**
 * Represents a provision class.
 *
 * main call
 * return type boolean
 */

class index
{
    public $request;

    /**
     * Represents a provision construct class.
     *
     * $data main variables
     * return type string
     */
    public function __construct()
    {
        //get construct
    }

    /**
     * provision for get method.
     *
     * @return array
     */
    public function getProvision()
    {

        //get provision
        return [
            'success'=>true,
            'message'=>'Get Provision Error'
        ];
    }

    /**
     * provision for post method.
     *
     * @return array
     */
    public function postProvision()
    {

        //post provision
        return [
            'success'=>true,
            'message'=>'Post Provision Error'
        ];
    }


    /**
     * dont run this services.
     *
     * @return array
     */
    public function getExcept(){

        return [
            //app.'/stk'
        ];
    }


    /**
     * dont run this services.
     *
     * @return array
     */
    public function postExcept(){

        return [
            //app.'/stk'
        ];
    }

}
