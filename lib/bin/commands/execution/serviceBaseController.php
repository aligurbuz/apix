<?php
/**
 * Service base controller
 * it is mainly service provider for service
 * service provider
 */

namespace src\app\__projectName__\v1;

use Src\Store\Services\Httprequest as Request;

class serviceBaseController
{
    //default lang name
    public $lang='tr';

    //default boot name
    public $boot=false;

    //data log
    public $log=false;

    //data object Loader
    public $objectLoader=false;

    //http request
    public $request;

    //default search driver
    public $search='elasticSearch';

    //default model
    public $model='sudb';

    //model pagination
    public $pagination=10;

    //platform config
    public $platform=false;


    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct()
    {
        $this->request=new Request();
    }

    /**
     * webserviceBoot is to use guzzle method for http.
     * it is related method for every service
     * method can produce output as string or array or object
     * @param service array or service data array
     * @return array
     */
    public function webServiceBoot()
    {
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

    /**
     * localization features provide a convenient way to retrieve strings in various languages,
     * allowing you to easily support multiple languages within your application.
     * Language strings are stored in files within the src/app/project_name/storage directory.
     * Within this directory there should be a subdirectory for each language supported by the application:
     * @return string
     */
    public function getLocalization()
    {
        return $this->lang;
    }


    /**
     * Get a unique fingerprint for the request / route / IP address.
     * if show paremeter is false,it returns md5 value
     * if show paremeter is true,it returns array values
     *
     * @return string
     */
    public function fingerPrint($show=false)
    {
        $list=[
            'ip'=>$this->request->getClientIp(),
            'getHost'=>$this->request->getHost(),
            'getBasePath'=>$this->request->getBasePath(),
            'deviceToken'=>\app::deviceToken(),
            'isSecure'=>$this->request->isSecure()

        ];

        if ($show===false) {
            return md5(implode("|", $list));
        }
        return $list;
    }


    /**
     * The EventDispatcher component provides tools that allow your application
     * components to communicate with each other by dispatching events and listening to them.
     * @event param src/store/services/event
     *
     * @return array
     */
    public function event()
    {
        $events =[
            'eventName'=>function () { }
        ];

        return $events;
    }
}
