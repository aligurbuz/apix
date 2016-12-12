<?php
/*
 * This file is main part of the fussy service.
 *
 * every request is called index method as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\fussy\v1\__call\promain;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class index extends app {

    public $test;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(){

    }

    /**
     * index method is main method.
     *
     * @return array
     */
    public function index(){

        //return index
        return ['message'=>'hello world'];
    }
}