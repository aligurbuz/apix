<?php
/*
 * This file is client and browser info of the fussy service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;
use Symfony\Component\HttpFoundation\Request;

/**
 * Represents a index class.
 *
 * main call
 * return type string
 */

class httprequest {

    /**
     * @var $request
     */
    public $request;

    /**
     * Constructor.
     * type dependency injection and function
     */
    public function __construct(){

        //get client request info
        $this->request=Request::createFromGlobals();
    }

    /**
     * get client ip.
     * @return mixed
     */
    public function getClientIp(){

        return $this->request->getClientIp();
    }

    /**
     * get client headers.
     * @return mixed
     */
    public function getHeaders(){

        return $this->request->headers->all();
    }

    /**
     * get client header key.
     * @return mixed
     */
    public function getHeader($data){

        return $this->request->headers->get($data);
    }

    /**
     * get add headers.
     * @param $header array
     * @return mixed
     */
    public function addHeader($header=array()){

        return $this->request->headers->add($header);
    }

    /**
     * get full url.
     * @return mixed
     */
    public function fullUrl(){

        return $this->request->getUri();
    }

    /**
     * get http host.
     * @return mixed
     */
    public function getHost(){

        return $this->request->getHttpHost();
    }

    /**
     * get base path.
     * @return mixed
     */
    public function getBasePath(){

        return $this->request->getBasePath();
    }

    /**
     * get base url.
     * @return mixed
     */
    public function getBaseUrl(){

        return $this->request->getBaseUrl();
    }

    /**
     * get isSecure url.
     * Checks whether the request is secure or not.
     * This method can read the client protocol from the "X-Forwarded-Proto" header
     * when trusted proxies were set via "setTrustedProxies()".
     * The "X-Forwarded-Proto" header must contain the protocol: "https" or "http".
     * If your reverse proxy uses a different header name than "X-Forwarded-Proto" ("SSL_HTTPS" for instance),
     * configure it via "setTrustedHeaderName()" with the "client-proto" key.
     * @return bool
     */
    public function isSecure(){

        return $this->request->isSecure();
    }


    /**
     * get getDefaultLocale url.
     * @return bool
     */
    public function getDefaultLocale(){

        return $this->request->getDefaultLocale();
    }

    /**
     * get getDefaultLocale url.
     * @param $locale null|string
     * @return mixed
     */
    public function setLocale($locale=null){
        if($locale!==null){
            return $this->request->setLocale($locale);
        }
        return null;

    }

    /**
     * get input.
     * @return mixed
     */
    public function input(){

        return $this->request->request->all();
    }

    /**
     * get query.
     * @return mixed
     */
    public function query(){

        return $this->request->query->all();
    }

    /**
     * get content.
     * @return mixed
     */
    public function content(){

        return $this->request->getContent();
    }


    /**
     * get input.
     * @return array
     */
    public function getQueryString($param=null){

        $list=[];
        if($this->request->getQueryString()!==null){
            $getQueryString=explode("&",$this->request->getQueryString());
            foreach ($getQueryString as $value){
                $valueexplode=explode("=",$value);
                $list[$valueexplode[0]]=$valueexplode[1];
            }
        }

        if($param===null){
            return $list;
        }

        if(array_key_exists($param,$list)){
            return $list[$param];
        }
        return null;

    }

    /**
     * get only client header.
     * @return array
     */
    public function getClientHeaders(){

        $headers=$this->getHeaders();
        $httpHeaders=['host','connection','cache-control','accept','upgrade-insecure-requests','user-agent',
                     'accept-encoding','accept-language','cookie','postman-token','content-length','origin','content-type','clientToken'];
        $list=[];
        foreach ($headers as $key=>$value) {
            if(!in_array($key,$httpHeaders)){
                $list[$key]=$value;
            }
        }
        return $list;

    }


    /**
     * get only client header.
     * @param $key string
     * @return boolean
     */
    public function existHeader($key){

        $header=$this->getHeaders();

        if(isset($header[$key])){

            return true;
        }

        return false;
    }


}
