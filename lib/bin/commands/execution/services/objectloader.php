<?php
/*
 * This file is data object loader of the every service.
 *
 * object loader returns array value
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\provisions;
use src\store\services\httprequest as Request;

/**
 * Represents a object loader class.
 *
 * main call
 * return type boolean
 */

class objectloader {

    public $request;

    /**
     * Represents a object loader construct class.
     *
     * $data main variables
     * return type string
     */
    public function __construct(Request $request){

        $this->request=$request;
    }

    /**
     * object loader for get method.
     *
     * @return array
     */
    public function getObjectLoader(){

        //get object
        $list=[];
        //$list['client']['developer']='aligurbuz';

        //return
        return $list;
    }

    /**
     * object loader for post method.
     *
     * @return array
     */
    public function postObjectLoader(){

        //get object
        $list=[];
        //$list['client']['developer']='aligurbuz';

        //return
        return $list;
    }


    /**
     * dont run this services.
     *
     * @return array
     */
    public function getExcept(){

        return [
            //app.'/service/method'
        ];
    }


    /**
     * dont run this services.
     *
     * @return array
     */
    public function postExcept(){

        return [
            //app.'/service/method'
        ];
    }





}
