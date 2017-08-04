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

use Apix\Utils;
use Apix\StaticPathModel;

/**
 * Represents a index class.
 *
 * main call
 * return type string
 *
 */

class simpleXml {

    /**
     * @var $url
     */
    public static $xml;

    /**
     * @var pointer
     */
    public static $pointer=false;


    /**
     * return mixed
     */
    public static function url($url=false,$pointer=false){

        if($url){
            self::$xml=app('guzzle')->get($url,'xml');

            if($pointer){
                return self::$xml;
            }
        }

        self::$pointer=true;

        return new static;
    }

    public static function point($point=false){

        if($point && self::$pointer){

            /**
             * get webservice config
             * return object
             */
            $webServiceConfig=Utils::resolve(staticPathModel::getWebServicePath().'\\config');

            /**
             * @var $webServiceConfigUrlPrefix
             * url config load
             */
            $webServiceConfigUrlPrefix=$webServiceConfig->urlPrefix;

            /**
             * set webservice config point
             * return string
             */
            $webServiceConfigPoint=$point;
            if(array_key_exists($point,$webServiceConfig->endPoints())){
                $webServiceConfigPoint=$webServiceConfig->endPoints($point);
            }

            /**
             * get url finally
             */
            $webServiceConfigUrl=$webServiceConfigUrlPrefix.''.$webServiceConfigPoint;
            static::url($webServiceConfigUrl,true);
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

}
