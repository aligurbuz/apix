<?php
/**
 * Service base controller
 * it is mainly service provider for service
 * service provider
 */

namespace src\app\__projectName__\v1;


class serviceBaseController
{
    //default lang name
    public $lang='tr';

    //default lang name
    public $boot=false;

    /**
     * webserviceBoot is to use guzzle method for http.
     * it is related method for every service
     * method can produce output as string or array or object
     * @param service array or service data array
     * @return array
     */
    public function webServiceBoot(){
        return [
            /*
            'stk'=>[
                //optional
                'all'=>['boot1'=>'bootOne'],
                //optional
                'index'=>['boot2'=>'bootTwo']
            ]*/
        ];
    }
}