<?php
/*
 * This file is pre runner and after middleware of the every service.
 *
 * preloader after middleware
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

class afterMiddleware {

    public $data;

    /**
     * Represents a afterMiddleware class.
     *
     * $data main variables
     * return type string
     */
    public function __construct($data){

        $this->data=$data;
    }

    /**
     * after middleware handle.
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
