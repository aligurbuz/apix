<?php
/*
 * This file is provision of the every service.
 *
 * provision returns boolean value (true|false)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\provisions;
use src\services\httprequest as request;

/**
 * Represents a provision class.
 *
 * main call
 * return type boolean
 */

class index {

    public $request;

    /**
     * Represents a provision construct class.
     *
     * $data main variables
     * return type string
     */
    public function __construct(request $request){

        $this->request=$request;
    }

    /**
     * provision for get method.
     *
     * @return array
     */
    public function getProvision(){

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
    public function postProvision(){

        //default
        $success=true;

        //need token for production
        //$token=new \src\services\httpCsrfToken();
        //$success=($token->checkTokenForPostMethod(\app::post("_token"))) ? true : false;

        //post provision
        return [
            'success'=>$success,
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
