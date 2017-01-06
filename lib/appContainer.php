<?php

namespace lib;

class appContainer {

    public static function __callStatic($class=null,$value=[]){
        if($class!==null){
            //class resolve
            $container = \DI\ContainerBuilder::buildDevContainer();

            //container namespace edit
            $containeralias=str_replace("\\","\\\\",$class);

            $inApp="\\src\\app\\".app."\\".version."\\config\\app";
            $inApp=$container->get($inApp);
            $inAppContainer=$inApp->container();

            $inAppContainerList=[];
            foreach ($inAppContainer as $inkey=>$invalue){
                if(!array_key_exists($inkey,\src\config\app::getContainer())){

                    $inAppContainerList[$inkey]=$invalue;
                }
            }

            $lastContainer=\src\config\app::getContainer()+$inAppContainerList;

            //check container class alias
            if(array_key_exists($containeralias,$lastContainer)){
                $class=$lastContainer[$class];
                return $container->get($class);

            }

            //return pure container
            return $container->get($class);
        }

    }
}