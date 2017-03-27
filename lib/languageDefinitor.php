<?php

namespace lib;
use Symfony\Component\Yaml\Yaml;

class languageDefinitor {


    /**
     * service environment constructs.
     *
     * outputs get file.
     *
     * @internal param $string
     */
    public function __construct(){}

    /**
     * service language definitor runner method.
     *
     * outputs get file.
     *
     * @param string
     * @return response language definitor runner
     */
    public static function get($data=null,$langName=null,$def=null){

        if($data!==null && $langName!==null){
            //data parse
            $dataParse=explode(".",$data);

            //default lang
            $default=self::getDefaultLang($langName,$def);
            $defaultLang=self::getDefaultLangParse($default);

            //service yaml lang
            $langStorage=root.'/src/app/'.app.'/storage/lang/'.$langName.'/'.service.'_'.$dataParse[0].'.yaml';
            $storageStatus=true;
            if(!file_exists($langStorage)){
                //normal yaml
                $langStorage=root.'/src/app/'.app.'/storage/lang/'.$langName.'/'.$dataParse[0].'.yaml';
                if(!file_exists($langStorage)){

                    $langStorage=root.'/src/storage/lang/'.$langName.'/'.$dataParse[0].'.yaml';

                    if(!file_exists($langStorage)){
                        $langStorage=root.'/src/app/'.app.'/storage/lang/'.$def.'/'.$dataParse[0].'.yaml';
                        if(!file_exists($langStorage)){
                            $storageStatus=false;
                        }
                    }

                }
            }

            $lang=null;
            if($storageStatus){
                $lang=Yaml::parse(file_get_contents($langStorage));
            }

            //reel data
            $words=(count($defaultLang)==0 OR $lang==null) ? [] : array_merge($defaultLang,$lang);

            //if there is key : output
            if(array_key_exists($dataParse[1],$words)){
                return $words[$dataParse[1]];
            }

        }
        return null;

    }



    /**
     * service language default runner method.
     *
     * outputs get file.
     *
     * @param string
     * @return response language default runner
     */
    private static function getDefaultLang($langName=null,$def=null){
        //default lang
        $default=root.'/src/app/'.app.'/storage/lang/'.$langName.'/default.yaml';
        if(!file_exists($default)){
            $default=root.'/src/app/'.app.'/storage/lang/'.$def.'/default.yaml';
        }
        return $default;
    }


    /**
     * service language default parse runner method.
     *
     * outputs get file.
     *
     * @param string
     * @return response language default parse runner
     */
    private static function getDefaultLangParse($default=null){
        $defaultLang=null;
        if(file_exists($default)){
            $defaultLang=Yaml::parse(file_get_contents($default));
        }

        if($defaultLang==null){
            $defaultLang=[];
        }

        return $defaultLang;
    }



}