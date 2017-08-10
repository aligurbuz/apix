<?php
/*
 * This file is json class service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\packages\providers\webservice\src;

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
     * @var $namelist
     */
    public static $namelist=[];


    /**
     * construct method
     */
    public function __construct(){

        /**
         * @var set config param
         */
        if(count(self::$param)===0){

            self::webServiceConfigMethod('setUrlGetQuery','query');
            self::webServiceConfigMethod('setHeaders','headers');

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

        self::$param['query']=$query;
        return new static;
    }

    public static function headers($headers=array()){

        self::$param['headers']=$headers;
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

        self::namelist();

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
    public static function __call($namelist,$args){

        self::$namelist[$namelist]=$args[0];
        return new static;
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
    public static function webServiceConfigMethod($method,$type){

        $webServiceConfig=staticPathModel::getWebServiceConfig();
        if(method_exists($webServiceConfig,$method)){

            $queryList=$webServiceConfig->$method();


            if(self::$group===null){
                self::$param[$type]=$queryList;
            }

            if(isset($queryList[self::$group])){
                self::$param[$type]=$queryList[self::$group];
            }


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

    /**
     *
     */
    private static function namelist(){

        foreach (self::$namelist as $namekey=>$namevalue){

            if(in_array(':'.$namekey,self::$param['query'])){
                $queryNeedle=array_search(':'.$namekey,self::$param['query']);
                self::$param['query'][$queryNeedle]=self::$namelist[$namekey];
            }
        }
    }

}
