<?php
/**
 * Service log controller
 * it is mainly service logging for service
 * service logging
 */

namespace src\app\__projectName__\v1;
use src\services\httprequest as request;


class serviceLogController
{
    public $request;
    public $status=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(request $request){

        //get request info
        $this->request=$request;
    }

    /**
     * handle.
     *
     * @param data client responses
     * @return bool
     */
    public function handle($data=array()){

        //logging data
        return true;
    }


}