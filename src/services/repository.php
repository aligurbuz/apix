<?php
/*
 * This file is client and service extra branching of the repository service.
 *
 * client and repository info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;

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
        return new self;


    }

    /**
     * get repository class call.
     *
     * @return array
     */
    public function __call($name,$arguments=[]){
        if(defined("devPackage")){
            $repoNameSpace='\\src\\packages\\dev\\'.service.'\\devpack\\repository\\'.self::$repo.'\\index'; ;
        }
        else{
            $repoNameSpace='\\src\\app\\'.app.'\\'.version.'\\repository\\'.self::$repo.'\\index';
        }

        if(class_exists($repoNameSpace)){
            return \app::resolve($repoNameSpace)->$name();
        }
        return null;

    }

}
