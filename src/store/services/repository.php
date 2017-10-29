<?php
namespace Src\Store\Services;

use Apix\Utils;

/**
 * Represents a index class.
 *
 * main call
 * return type string
 */

class Repository {

    /**
     * @var $repo null
     */
    public static $repo=null;

    /**
     * @var $bind null
     */
    public static $bind=[];


    /**
     * @param $name
     * @param $arguments
     * @return repository
     */
    public static function __callStatic($name, $arguments){

        self::$repo=$name;
        self::$bind=(isset($arguments[0])) ? $arguments[0] : [];
        return new self;


    }


    /**
     * @param $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments=[]){

        if(defined("devPackage")){
            $repoNameSpace='\\src\\store\\packages\\dev\\'.service.'\\devpack\\repository\\'.self::$repo.'\\index'; ;
        }
        else{
            $repoNameSpace='\\src\\app\\'.app.'\\'.version.'\\optional\\repository\\'.self::$repo.'\\index';
        }

        if(class_exists($repoNameSpace)){

            return Utils::makeBind($repoNameSpace,self::$bind)->$name($arguments);
        }
        throw new \BadFunctionCallException('Not available repo you want');

    }

}
