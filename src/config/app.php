<?php

namespace src\config;
use src\services\httprequest as request;

class app {

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(){

        //get request info
        $this->request=new request();
    }

    /**
     * get container.
     *
     * @param type dependency injection and function
     * @return array
     */
    public static function getContainer(){

        return [

            'device'    =>'\\src\\services\\mobileDetect',
            'redis'     =>'\\src\\services\\redis',
            'guzzle'    =>'\\src\\services\\guzzle'
        ];

    }

    /**
     * response environment.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function environment(){

        $envpath=root.'/.env';

        if(file_exists($envpath)){
            return 'local';
        }else{
            return 'production';
        }

    }

    /**
     * response device token.
     *
     * outputs device token.
     *
     * @param string
     * @return response generate device token runner
     */

    public static function deviceToken($data=array(),$status=false){
        $devicetoken=$_SERVER['HTTP_USER_AGENT'];
        if(!$status){
            if(count($data)){
                foreach($data as $value){
                    $devicetoken.='__'.$value.'__';
                }
            }

            return md5($devicetoken);
        }


        return $devicetoken;
    }

    /**
     * response environment.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function resolve($class){

        $container = \DI\ContainerBuilder::buildDevContainer();
        return $container->get($class);

    }

    /**
     * response arraydelete.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function arrayDelete($data,$delete){

        $list=[];
        foreach($data as $key=>$value){
            if(!in_array($key,$delete)){
                $list[$key]=$value;
            }
        }

        return $list;
    }

    /**
     * response checkUrlParam.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function checkUrlParam($param=null){
        if($param==null){
            return false;
        }
        $border=new self;
        if(array_key_exists($param,$border->request->getQueryString())){
            return true;
        }
        return false;
    }

    /**
     * response getUrlParam.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function getUrlParam($param=null){
        if($param==null){
            return null;
        }
        $border=new self;
        $string=$border->request->getQueryString();
        if(array_key_exists($param,$string)){
            return $string[$param];
        }
        return null;
    }


    /**
     * response check token.
     *
     * outputs token check.
     *
     * @param string
     * @return response environment runner
     */

    public static function checkToken(){

        //get token
        $token="\\src\\provisions\\token";
        $token=self::resolve($token);
        $tokenhandle=$token->handle();
        $tokenexcept=$token->except();

        $queryParams=self::getQueryParamsFromRoute();

        //token provision
        if(array_key_exists("_token",$queryParams)){

            if(in_array($queryParams['_token'],$tokenhandle['tokens'])){

                if(!array_key_exists($queryParams['_token'],$tokenhandle['clientIp'])){
                    return true;
                }

                if($tokenhandle['clientIp'][$queryParams['_token']]==$_SERVER['REMOTE_ADDR']){
                    return true;
                }

            }
        }

        return false;

    }

    /**
     * get directory name.
     *
     * directory name
     *
     * @param string
     * @return directory name runner
     */

    public static function getDirectoryName(){

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

    public static function getServiceNameAndMethodFromRequestUri(){

        $service=str_replace("/".self::getDirectoryName()."/service/","",self::requestUri());
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

    public static function getPureMethodNameFromService(){

        $service=self::getServiceNameAndMethodFromRequestUri();
        return preg_replace('@\?(.*)@is','',end($service));
    }


    /**
     * get query params
     *
     * query params
     *
     * @param string
     * @return query params runner
     */

    public static function getQueryParamsFromRoute(){

        $service=self::getServiceNameAndMethodFromRequestUri();
        $params=preg_replace('@'.self::getPureMethodNameFromService().'\?@is','',end($service));

        if($params==self::getPureMethodNameFromService()) {
            return [];
        }
        else {

            $getParams=explode("&",$params);
            $paramlist=[];
            foreach ($getParams as $main){
                $getParamsMain=explode("=",$main);
                $paramlist[$getParamsMain[0]]=$getParamsMain[1];
            }

            return $paramlist;
        }
    }

    /**
     * get request uri.
     *
     * this checks request uri parameter.
     *
     * @param string
     * @return request uri runner
     */

    public static function requestUri(){

        return $_SERVER['REQUEST_URI'];
    }



}
