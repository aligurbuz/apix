<?php
/*
 * This file is search class service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;
use Src\Packages\Providers\Search\Search as searchEngine;

/**
 * Represents a index class.
 *
 * main call
 * return type string
 *
 */

class search {

    public $search;


    /**
     * get construct.
     *
     */
    public function __construct(){
        $this->search=new searchEngine();
    }

    /**
     * get run.
     *
     */
    public function driver($driver=null){
        return $this->search->runEngineHandle($driver);
    }

}
