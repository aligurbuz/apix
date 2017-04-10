<?php
/*
 * This file is pre runner and before middleware of the every service.
 *
 * preloader before middleware
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\middleware;

/**
 * Represents a beforeMiddleware class.
 *
 * main call
 * return type string
 */

class beforeMiddleware {

    public $data;

    /**
     * Represents a beforeMiddleware class.
     *
     * $data main variables
     * return type string
     */
    public function __construct($data){

        $this->data=$data;
    }

    /**
     * before middleware handle.
     *
     * @return array
     */
    public function handle(){

        //make somethings
    }


    /**
     * dont run this services.
     *
     * @return array
     */
    public function except(){

        return [
            //'app/service/method'
        ];
    }





}
