<?php

namespace lib;

class appBootLoader {


    /**
     * get file boot params.
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    private static function boot($serviceMethod){
        $bootFile=self::bootFileResolve();
        if($bootFile->boot===true){
            $bootList=[];
            $boot=$bootFile->webServiceBoot();
            if(array_key_exists(service,$boot)){
                if(array_key_exists('all',$boot[service])){
                    $bootList[]=$boot[service]['all'];
                }

                if(array_key_exists($serviceMethod,$boot[service])){
                    $bootList[]=$boot[service][$serviceMethod];
                }
            }

            return $bootList;
        }

        return [];
    }


    /**
     * get file boot params.
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    private static function bootFileResolve(){
        $bootFile="\\src\\app\\".app."\\".version."\\serviceBaseController";
        return \src\config\app::resolve($bootFile);

    }




}