<?php
/**
 * Service log controller
 * it is mainly service logging for service
 * service logging
 */

namespace src\app\__projectName__\v1;
use src\services\httprequest as request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler as StreamHandler;


class serviceLogController
{
    public $request;
    public $status=false;
    public $logger;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(request $request){

        //get request info
        $this->request=$request;
        $this->logger=new logger('log');
        $this->logger->pushHandler(new StreamHandler(root.'/src/app/'.app.'/storage/logs/access.log', Logger::INFO));
    }

    /**
     * handle.
     *
     * @param data client responses
     * @return bool
     */
    public function handle($data=array()){

        //logging data
        return $this->logger->info(json_encode($data));
    }


}