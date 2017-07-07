<?php
/**
 * Service base controller
 * it is mainly service provider for service
 * service provider
 */

namespace src\app\testApp\v1;

use Src\Store\Services\Httprequest as Request;

class serviceBaseController
{
    //response object
    public $response='json';

    //default lang name
    public $lang='tr';

    //data log
    public $log=false;

    //cache Adapter
    public $cacheAdapter='file';

    //data object Loader
    public $objectLoader=false;

    //default search driver
    public $search='elasticSearch';

    //default model
    public $model='sudb';

    //platform config
    public $platform=false;

    //throttle status
    public $throttle;


    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct()
    {
        $this->throttle=$this->throttle();
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
     * service rate limit query,
     * @return boolean
     */
    public function throttle()
    {
        return false;
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
        $request=new Request();
        $list=[
            'ip'=>$request->getClientIp(),
            'getHost'=>$request->getHost(),
            'getBasePath'=>$request->getBasePath(),
            'deviceToken'=>\app::deviceToken(),
            'isSecure'=>$request->isSecure()

        ];

        if ($show===false) {
            return md5(implode("|", $list));
        }
        return $list;
    }


    /**
     * handle.
     *
     * @param data client responses
     * @return bool
     */
    public function setLogger($data,$logInstance)
    {

        //logging data
        $loggerType=$logInstance->loggerType;
        return $logInstance->logger->$loggerType($data);
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
