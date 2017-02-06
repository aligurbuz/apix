<?php
/*
 * This file is usefull class and collection of the api service.
 *
 * client and collection info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;
use Illuminate\Support\Collection;

/**
 * Represents a collection class.
 *
 * main call
 * return type string
 */

class appCollection {


    /**
     * collection avg get data.
     *
     * @return collection class
     */
    public function avg($data=array())
    {
        if(count($data)){
            return collect($data)->avg();
        }
    }


}
