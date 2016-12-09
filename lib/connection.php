<?php

namespace lib;

class connection {

    /**
     * connect to api service (created service).
     *
     * Enabled by default.
     *
     * @param bool $bool
     * @return connectin runner
     */
    public static function run() {

        $border=new self;

        $service=$border->getServiceNameAndMethodFromRequestUri();
        $serviceMethod=$border->getPureMethodNameFromService();

        //service main file extends this file
        require(root . '/src/app/trendmax/v1/bar/app.php');

        //service main file
        require(root . '/src/app/'.$service[0].'/v1/'.$service[1].'/index.php');

        //resolve process
        $resolve=require(root.'/lib/resolver.php');
        $resolve=new \classresolver();

        //apix resolve
        $apix=$resolve->resolve("\\src\\app\\".$service[0]."\\v1\\".$service[1]."\\index");

        //call service
        return $apix->$serviceMethod();
    }

    /**
     * get request uri.
     *
     * this checks request uri parameter.
     *
     * @param string
     * @return request uri runner
     */

    private function requestUri(){

        return $_SERVER['REQUEST_URI'];
    }

    /**
     * get directory name.
     *
     * directory name
     *
     * @param string
     * @return directory name runner
     */

    private function getDirectoryName(){

        $root=explode("/",root);
        return end($root);
    }


    /**
     * compare with root to request uri.
     *
     * compare request uri
     *
     * @param string
     * @return request uri compare runner
     */

    private function getServiceNameAndMethodFromRequestUri(){

        $service=str_replace("/".$this->getDirectoryName()."/service/","",$this->requestUri());
        return explode("/",$service);
    }


    /**
     * get pure method from service
     *
     * pure method name
     *
     * @param string
     * @return pure method runner
     */

    private function getPureMethodNameFromService(){

        $service=$this->getServiceNameAndMethodFromRequestUri();
        return preg_replace('@\?(.*)@is','',end($service));
    }
}