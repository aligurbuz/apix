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

class token {

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
    public function handle(){

        //status check
        //false status : access without token
        //tru status : access with token
        $status=(\app::environment()=="local") ? false : false;

        //token status false|true
        $token['status']=$status;

        //service tokens
        $token['tokens'][]='apix';

        //client ip tokens
        $token['clientIp']=[];
        //$token['clientIp']['apix']='192.168.33.1';

        return $token;
    }


    /**
     * dont run this services.
     *
     * @return array
     */
    public function Except(){

        //except routes
        $except=[];
        //$except[]=app.'/service/method?';

        //excepts client ip
        $except['clientIp']=[];
        //$except['clientIp']['192.168.33.1'][]=app.'/service/method?';

        return $except;
    }


}
