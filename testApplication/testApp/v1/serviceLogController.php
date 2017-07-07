<?php
/**
 * Service log controller
 * it is mainly service logging for service
 * service logging
 */

namespace src\app\mobi\v1;

use Src\Store\Services\Httprequest as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler as StreamHandler;
use Apix\Utils;
use Apix\StaticPathModel;

class serviceLogController extends serviceBaseController
{
    public $logger;
    public $logPath=null;
    public $loggerType;
    public $loggerTypes=['access'=>'INFO','error'=>'ERROR'];

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct($errorFileName='access')
    {

        /**
         * Get Log Component.
         *
         * @param mixed
         * @monoLog class call
         */
        $this->logger=new logger('log');

        /**
         * Get Log Path.
         *
         * @param string
         * @info log register path
         */
        $this->logPath=staticPathModel::getProjectPath(app).'/storage/logs/';

        /**
         * Log Pushhandler.
         *
         * @param mixed
         * @result log push handler
         */
        $this->loggerType=$this->loggerTypes[$errorFileName];
        $this->logger->pushHandler(new StreamHandler($this->logPath.''.$errorFileName.'.log', Logger::INFO));
    }

    /**
     * handle.
     *
     * @param data client responses
     * @return bool
     */
    public function handle($data=array())
    {

        /**
         * Logging data.
         *
         * @param @data array
         * set Logger calling
         */
        return $this->setLogger(json_encode($data),$this);
    }



}
