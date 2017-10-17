<?php
/*
 * This file is client and browser info of the fussy service.
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

class mobileDetect {

    public $mobile;

    /**
     * Constructor.
     */
    public function __construct(){

        //get client request info
        require_once(root . '/vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php');
        $this->mobile=new \Mobile_Detect;

    }

    /**
     * get isMobile.
     *
     * @return bool true|false
     */
    public function isMobile(){

        return $this->mobile->isMobile();
    }

    /**
     * get isTable.
     *
     * @return bool true|false
     */
    public function isTablet(){

        return $this->mobile->isTablet();
    }

    /**
     * @method is
     * @param $data
     * @return bool true|false
     */
    public function is($data){

        return $this->mobile->is($data);
    }


}
