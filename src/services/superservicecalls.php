<?php
/*
 * This file is client and super service call info of the global service.
 *
 * client and super call info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;

/**
 * Represents a super service call class.
 *
 * main call
 * return type string
 */

class superservicecalls {


    /**
     * superservice calls set data.
     *
     * @return super service class
     */
    public function ready(){
        //set return
        return \app::resolve("\\src\\app\\".app."\\".version."\\serviceReadyController");
    }




}
