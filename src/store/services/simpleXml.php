<?php
/*
 * This file is xml class service.
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
 * Represents a xml class.
 *
 * call1 :  \Xml::url(url)->point(pointer)->get()
 * call2 :  \Xml::url()->get()
 * call3 :  \Xml::groupName()->point(pointer)->get()
 * return type string
 *
 */

class simpleXml {

    /**
     * @var $url
     */
    public static $url=false;

    /**
     * @var $url
     */
    public static $xml;

    /**
     * @var pointer
     */
    public static $pointer=false;

    /**
     * @var $group
     */
    public static $group=null;


    /**
     * return mixed
     */
    public static function url($url=false,$pointer=false){

        if($url){
            self::$url=true;
            self::$xml=app('guzzle')->get($url,'xml');

            if($pointer){
                return self::$xml;
            }
        }

        self::$pointer=true;

        return new static;
    }

    public static function point($point=false){

        if(self::$url===false){
            self::$pointer=true;
        }

        if($point && self::$pointer){
            static::url(\app::getWebServiceConfigUrl(self::$group,$point),true);
        }

        return new static;
    }

    /**
     * @method test
     */
    public static function get($loadData=false){

        /**
         * simple Xml load
         * return xml
         */
        define('guzzleOutPutter',app('base')->response);

        /**
         * @var $xml
         * get url xml data
         */
        $xml = simplexml_load_string(self::$xml, "SimpleXMLElement", LIBXML_NOCDATA);

        /**
         * @var $json
         * get to array xml data
         */
        $json = json_encode($xml);

        /**
         * get finally output
         */
        return (object)json_decode($json,TRUE);


    }


    /**
     * @method test
     */
    public static function toArray($data){

        $xmlToArrayResolve=new \SimpleXMLElement($data);
        return json_decode(json_encode($xmlToArrayResolve),1);

    }


    /**
     * @method __callStatic
     */
    public static function __callStatic($group,$args){
        self::$group=$group;
        return new static;
    }

}
