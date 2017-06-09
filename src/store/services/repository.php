<?php
/*
 * This file is client and service extra branching of the repository service.
 *
 * client and repository info
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
 */

class repository {

    public static $repo=null;


    /**
     * get repository repo name.
     *
     * @return array
     */
    public static function __callStatic($name,$arguments=[]){
        self::$repo=$name;
        if(array_key_exists(0,$arguments)){
            if($arguments[0]){
                $instance=new self;
                return $instance->get($arguments);
            }
        }
        return new self;


    }

    /**
     * get repository class call.
     *
     * @return array
     */
    public function __call($name,$arguments=[]){
        if(defined("devPackage")){
            $repoNameSpace='\\src\\store\\packages\\dev\\'.service.'\\devpack\\repository\\'.self::$repo.'\\index'; ;
        }
        else{
            $repoNameSpace='\\src\\app\\'.app.'\\'.version.'\\optional\\repository\\'.self::$repo.'\\index';
        }

        if(class_exists($repoNameSpace)){
            return \Apix\utils::resolve($repoNameSpace)->$name();
        }
        return null;

    }

}
