<?php
/*
 * This file is json class service.
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
 * Represents a json class.
 *
 * call1 :  \jsonClient::url(url)->point(pointer)->get()
 * call2 :  \jsonClient::url()->get()
 * call3 :  \jsonClient::groupName()->point(pointer)->get()
 * return type string
 *
 */

class jsonClient {

    /**
     * @var $url
     */
    public static $url=false;

    /**
     * @var $url
     */
    public static $json;

    /**
     * @var pointer
     */
    public static $pointer=false;

    /**
     * @var $group
     */
    public static $group=null;

    /**
     * @var $query
     */
    public static $param=[];


    /**
     * construct method
     */
    public function __construct(){

        /**
         * @var set config param
         */
        if(count(self::$param)===0){
            self::webServiceConfigMethod('setUrlGetQuery');
            if(is_array(self::$param) AND count(self::$param)){
                self::$param=['query'=>self::$param];
            }

        }
    }


    /**
     * return mixed
     */
    public static function url($url=false,$pointer=false){

        if($url){
            self::$url=$url;
            self::$json=app('guzzle');

            if($pointer){
                return self::$json;
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

    public static function query($query=array()){

        self::$param=['query'=>$query];
        return new static;
    }


    /**
     * @method get
     */
    public static function get(){

        /**
         * simple jsonClient load
         * return json
         */
        define('guzzleOutPutter',app('base')->response);

        /**
         * get finally output
         */
        return self::$json->get(self::$url,'json',self::$param);


    }

    /**
     * @method post
     */
    public static function post($post=[]){

        /**
         * simple jsonClient load
         * return json
         */
        define('guzzleOutPutter',app('base')->response);

        /**
         * get finally output
         */

        self::httpBuildQuery();

        return self::$json->post(self::$url,$post,'json');


    }

    /**
     * @method __callStatic
     */
    public static function __callStatic($group,$args){

        self::$group=$group;
        return new static;
    }

    /**
     *
     */
    public static function webServiceConfigMethod($method){

        $webServiceConfig=staticPathModel::getWebServiceConfig();
        if(method_exists($webServiceConfig,$method)){
            self::$param=$webServiceConfig->$method();
        }
    }

    /**
     *
     */
    private static function firstSeperate (){

        $firstSeperate='?';
        if(preg_match('@\?@is',self::$url)){
            $firstSeperate='&';
        }
        return $firstSeperate;
    }

    /**
     *
     */
    private static function httpBuildQuery(){

        if(count(self::$param)){
            self::$url=self::$url.''.self::firstSeperate().''.http_build_query(self::$param['query']);
        }
    }

}
