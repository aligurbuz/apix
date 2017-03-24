<?php
/*
 * This file is client and browser info of the fussy service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;
use Symfony\Component\HttpFoundation\Request;

/**
 * Represents a index class.
 *
 * main call
 * return type string
 */

class httprequest {

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(){

        //get client request info
        $this->request=Request::createFromGlobals();
    }

    /**
     * get client ip.
     *
     * @return array
     */
    public function getClientIp(){

        return $this->request->getClientIp();
    }

    /**
     * get client headers.
     *
     * @return object
     */
    public function getHeaders(){

        return $this->request->headers->all();
    }

    /**
     * get client header key.
     *
     * @return object
     */
    public function getHeader($data){

        return $this->request->headers->get($data);
    }

    /**
     * get add headers.
     *
     * @return array
     */
    public function addHeader($header=array()){

        return $this->request->headers->add($header);
    }

    /**
     * get full url.
     *
     * @return object
     */
    public function fullUrl(){

        return $this->request->getUri();
    }

    /**
     * get http host.
     *
     * @return string
     */
    public function getHost(){

        return $this->request->getHttpHost();
    }

    /**
     * get base path.
     *
     * @return string
     */
    public function getBasePath(){

        return $this->request->getBasePath();
    }

    /**
     * get base url.
     *
     * @return string
     */
    public function getBaseUrl(){

        return $this->request->getBaseUrl();
    }

    /**
     * get input.
     *
     * @return string
     */
    public function input(){

        return $this->request->request->all();
    }

    /**
     * get input.
     *
     * @return string
     */
    public function getQueryString(){

        $list=[];
        if($this->request->getQueryString()!==null){
            $getQueryString=explode("&",$this->request->getQueryString());
            foreach ($getQueryString as $value){
                $valueexplode=explode("=",$value);
                $list[$valueexplode[0]]=$valueexplode[1];
            }
        }

        return $list;
    }

    /**
     * get only client header.
     *
     * @return string
     */
    public function getClientHeaders(){

        $headers=$this->getHeaders();
        $httpHeaders=['host','connection','cache-control','accept','upgrade-insecure-requests','user-agent',
                     'accept-encoding','accept-language','cookie','postman-token','content-length','origin','content-type'];
        $list=[];
        foreach ($headers as $key=>$value) {
            if(!in_array($key,$httpHeaders)){
                $list[$key]=$value;
            }
        }
        return $list;


    }
}
