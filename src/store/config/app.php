<?php

namespace Src\Store\Config;

use Src\Store\Services\Httprequest as Request;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Apix\Utils;
use Apix\StaticPathModel;

class App {

    /**
     * Symfony request object.
     * request module and symfony http foundation
     * constructor object
     */
    public $request;

    /**
     * Path Belonging To Service methods .
     */
    private static $servicePath='\\src\\store\\services\\';

    /**
     * Path Belonging To providers methods .
     */
    private static $providers='\\src\\store\\packages\\providers\\';

    /**
     * Constructor.
     * definition : class preloader with default
     * symfony component request class
     */
    public function __construct(){

        //get request info
        $this->request=new request();
    }

    /**
     * get container.
     * definition:class is defined in a container
     * and it is called as app("device")->method()
     * @return array
     */
    public static function getContainer($container=null){

        $containers= [

            'device'                =>self::$servicePath.'mobileDetect',
            'redis'                 =>self::$servicePath.'redis',
            'guzzle'                =>self::$servicePath.'guzzle',
            'rmq'                   =>self::$servicePath.'rabbitMQ',
            'platform'              =>self::$servicePath.'platform',
            'collection'            =>self::$servicePath.'appCollection',
            'session'               =>self::$servicePath.'httpSession',
            'file'                  =>self::$servicePath.'fileProcess',
            'search'                =>self::$servicePath.'search',
            'cache'                 =>self::$servicePath.'cache',
            'pushNotification'      =>self::$servicePath.'pushNotifications',
            'event'                 =>self::$servicePath.'event',
            'date'                  =>self::$servicePath.'date',
            'sparse'                =>self::$servicePath.'sparseFilter',
            'xml'                   =>self::$servicePath.'simpleXml',
            'soap'                  =>self::$servicePath.'soapClient',
            'outputResolver'        =>self::$servicePath.'outputResolver',
            'pipeline'              =>self::$servicePath.'pipeline',
        ];

        //if container is null,all containers are evaluated
        //if container is not null,only selected container is evaluated
        return ($container==null) ? $containers : $containers[$container];

    }

    /**
     * get definitive app.
     * definition:classes is defined by manager
     * @return array
     */
    public static function getAppDefinition(){

        return [];

    }

    /**
     * you can directly use as new \class
     * @method getClassAliasLoader
     * @return array
     */
    public static function getClassAliasLoader(){

        //defines
        return [

            //alias loader list
            'Date'                      =>self::$servicePath.'date',
            'outputResolver'            =>self::$servicePath.'outputResolver',
            'Collection'                =>self::$servicePath.'appCollection',
            'Faker'                     =>self::$servicePath.'faker',
            'XmlClient'                 =>'src\store\packages\providers\webservice\src\simpleXml',
            'SoapClient'                =>'src\store\packages\providers\webservice\src\soapClient',
            'JsonClient'                =>'src\store\packages\providers\webservice\src\jsonClient',
            'Pipeline'                  =>'League\Pipeline\Pipeline',
            'Response'                  =>'Apix\ResponseManager',
            'Repo'                      =>self::$servicePath.'repository',
            'Validator'                 =>'Respect\Validation\Validator',
            'dbCon'                     =>'\\src\\store\\config\\dbConnector',
            'event'                     =>'\\src\\store\\services\\event',
            'Mongo'                     =>'\\src\\store\\packages\\providers\\database\\mongodb\\builder'
        ];

    }


    /**
     * post method for services.
     * definition : it tells value of key coming with post
     * access : \app::post(key);
     * outputs environment.
     * @param $data
     * @return null
     */
    public static function post($data){

        $instance=new self;
        $request=$instance->request->input();

        /**
         * @var $request array
         */
        if(array_key_exists($data,$request)){
            return $request[$data];
        }
        return null;

    }


    /**
     * response device token.
     * definition : it generates device token for login
     * used http_user_agent as server variable
     * result md5 data
     * outputs device token.
     * device token is shown if status true
     * device token as hash is shown if status false
     * @param array $data
     * @param bool $status
     * @return string
     */
    public static function deviceToken($data=array(), $status=false){

        $deviceToken=$_SERVER['HTTP_USER_AGENT'];
        if(!$status){
            if(count($data)){
                foreach($data as $value){
                    $deviceToken.='__'.$value.'__';
                }
            }
            return md5($deviceToken);
        }
        return $deviceToken;
    }


    public static function dbConfig(){

        $config=StaticPathModel::$appNamespace."\\".app."\\".version."\\config\\database";
        return $config::dbsettings();
    }


    /**
     * response checkUrlParam.
     * definition : it checks query on url with the given param value
     * it returns boolean value (true|false) as result
     * outputs checkUrlParam.
     * @param $param boolean
     * @return boolean
     */
    public static function checkUrlParam($param=null){

        $instance=new self;
        if($param==null){
            return false;
        }
        if(array_key_exists($param,$instance->request->getQueryString())){
            return true;
        }
        return false;
    }

    /**
     * response getUrlParam.
     * definition : it returns query value on url with the given param value
     * it returns null or string data as result
     * outputs getUrlParam.
     * @param $param string|null
     * @return mixed
     */
    public static function getUrlParam($param=null){
        if($param==null){
            return null;
        }
        $instance=new self;
        $string=$instance->request->getQueryString();
        if(array_key_exists($param,$string)){
            return $string[$param];
        }
        return null;
    }


    /**
     * response check token.
     * definition : it checks token on url
     * provision token rule
     * outputs token check.
     * @param string
     * @return mixed
     */
    public static function checkToken($environment=null){

        //get token
        $token="".staticPathModel::$appNamespace."\\".app."\\".version."\\serviceTokenController";
        $token=utils::resolve($token);
        $tokenhandle=$token->handle();

        $queryParams=self::getQueryParamsFromRoute();

        if($environment!==null){
            $envStatus=$token->handle($environment);
            if(!$envStatus['status']){
                return false;
            }
        }

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
     * directory name
     * @param string
     * @return mixed
     */
    public static function getDirectoryName(){

        $root=explode("/",root);
        return end($root);
    }


    /**
     * compare with root to request uri.
     * compare request uri
     * @param string
     * @return mixed
     */
    public static function getServiceNameAndMethodFromRequestUri(){

        $service=str_replace("/".self::getDirectoryName()."/service/","",self::requestUri());
        return explode("/",$service);
    }


    /**
     * get pure method from service
     * pure method name
     * @param string
     * @return mixed
     */
    public static function getPureMethodNameFromService(){

        $service=self::getServiceNameAndMethodFromRequestUri();
        return preg_replace('@\?(.*)@is','',end($service));
    }


    /**
     * get query params
     * query params
     * @param string
     * @return mixed
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
     * this checks request uri parameter.
     * @param string
     * @return mixed
     */
    public static function requestUri(){

        return $_SERVER['REQUEST_URI'];
    }


    /**
     * get yaml file.
     * this checks request uri parameter.
     * @param $path string
     * @return mixed
     */
    public static function getYaml($path){

        try {
            return Yaml::parse(file_get_contents($path));
        } catch (ParseException $e) {
            return "Unable to parse the YAML string: ".$e->getMessage();
        }
    }


    /**
     * get getWebServiceConfigUrl.
     * this checks web service url for config.
     * @param bool|false $group false
     * @param null $point
     * @return mixed
     */
    public static function getWebServiceConfigUrl($group=false,$point=null){

        /**
         * get webservice config
         * return object
         */
        $webServiceConfig=Utils::resolve(staticPathModel::getWebServicePath().'\\connector');

        /**
         * @var $webServiceConfigUrlPrefix
         * url config load
         */
        $webServiceConfigUrlPrefix=$webServiceConfig->urlPrefix;

        if($group!==null){
            $webServiceConfigUrlPrefix=$webServiceConfig->urlPrefix[$group];
        }

        /**
         * if point is null
         * return $webServiceConfigUrlPrefix
         */
        if($point===null){
            return $webServiceConfigUrlPrefix;
        }

        /**
         * set webservice config point
         * return string
         */
        $webServiceConfigPoint=$point;
        if(array_key_exists($point,$webServiceConfig->endPoints(null,$group))){
            $webServiceConfigPoint=$webServiceConfig->endPoints($point,$group);
        }

        /**
         * get url finally
         */
        return $webServiceConfigUrlPrefix.''.$webServiceConfigPoint;
    }




}
