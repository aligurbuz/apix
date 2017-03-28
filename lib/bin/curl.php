<?php
/*
 * This file is console command .
 * console command
 * test
 */

namespace lib\bin;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use src\services\guzzle;

/**
 * Represents a console command example class.
 * access : api test
 * every method that on this command is called with console method as string on console
 * return type string
 */
class curl {

    /**
     * Represents a create method.
     * api test create --
     * return type string
     */
    public function handle($arguments){
        if(environment()=="local"){
            $arguments=(array)$arguments;
            foreach($arguments as $key=>$value){
                if($key=="get" OR $key=="post"){
                    $method=$key;
                    $url=$value;
                }
            }
            $guzzle=new guzzle();
            dd($guzzle->$method(env("apiprefix",null).'/'.$url));
        }
        return null;
    }

}