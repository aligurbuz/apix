<?php
/*
 * This file is app external environment.
 *
 * like stage and other platform
 * development settings
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src;
use src\services\httprequest as request;

/**
 * a other platform class.
 *
 * main call
 * return type boolean
 */

class env {

    public $request;

    /**
     * Represents a other platform construct class.
     *
     * $data main variables
     * return type string
     */
    public function __construct(request $request){

        $this->request=$request;
    }

    /**
     * environmentSetUp for other platform method.
     *
     * @return array
     */
    public function environmentSetUp(){

        return null;
        //example
        /*if($this->request->getClientIp()='x.x.x.'){
            return 'stage';
        }*/
    }


}
