<?php
/*
 * This file is search class service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;


/**
 * Represents a index class.
 *
 * main call
 * return type string
 *
 */

class outputResolver {

    public $data;

    public function __construct($data) {

        $this->data=$data;
    }

    /**
     * get run.
     *
     */
    public function getResult(){
        return $this->data;
    }

}
