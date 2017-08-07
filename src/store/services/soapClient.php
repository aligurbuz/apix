<?php
/*
 * This file is soap class service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;

use Apix\Utils;
use Apix\StaticPathModel;

/**
 * Represents a soap class.
 *
 * return type string
 *
 */

class soapClient {

    /**
     * @var $url
     */
    public static $url=false;

    /**
     * @var $url
     */
    public static $soap;

    /**
     * @var group
     */
    public static $group=null;

    /**
     * @var $group
     */
    public static $method=null;


    /**
     * return mixed
     */
    public static function url($url=false){

        if($url){
            self::$url=true;
            self::$soap=new \SoapClient($url,[
                'trace'=>1,
                'exceptions'=>0
            ]);

        }

        return new static;
    }

    /**
     * @method __call
     */
    public function __call($method,$args){
        self::$method=$method;
        return new static;
    }


    /**
     * @method test
     */
    public static function get($data=array()){

        /**
         * simple define load
         * return string
         */
        define('guzzleOutPutter',app('base')->response);

        $soapFunction=self::$method;

        if($soapFunction===null){
            throw new \InvalidArgumentException('Soap Function Error');
        }

        if(method_exists(self::$soap,$soapFunction)){
            return self::$soap->$soapFunction();
        }

        $soapData=self::$soap->$soapFunction($data);

        return $soapData;

    }


    /**
     * @method __callStatic
     */
    public static function __callStatic($group,$args){
        self::$group=$group;
        self::url(\app::getWebServiceConfigUrl(self::$group));
        return new static;
    }

}
