<?php
/*
 * The EventDispatcher component provides tools that allow your application
 * components to communicate with each other by dispatching events and listening to them.
 *
 * client and event dispatcher info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;

use Apix\utils;
use Apix\staticPathModel;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Represents a index class.
 *
 * main call
 * return type string
 */

class event {

    /**
     * @var $path
     */
    public $queue_path;

    /**
     * event constructor.
     */
    public function __construct() {

        $this->queue_path=staticPathModel::getJobPath().'\apix';
    }

    /**
     * @param null $name
     * @param callable|null $callback
     * @return mixed
     */
    public function queue($name=null, callable $callback=null){

        // if name variable is a closure value
        // it throws an error as invalidArgumentException
        if($name instanceof \Closure){
            throw new \InvalidArgumentException('queue name is invalid');
        }

        // check for task according name
        // if an task is available called name variable
        if($this->checkForTaskAccordingName($name)){

            // if checkForTaskAccordingName is true
            // queue is run
            $this->queueRun($name);
        }

        //callback return
        return call_user_func($callback);
    }


    /**
     * @param $name
     * @return boolean
     */
    private function checkForTaskAccordingName($name){

        //if a task is available for name
        // boolean true other boolean false
        if(class_exists($task=$this->queue_path.'\\'.$name.'\task')){
            return true;
        }
        return false;
    }

    /**
     * @param $name
     * process runner
     * @return void
     */
    private function queueRun($name){

        $process = new Process('php api job run '.app.' '.$name);
        $process->run();
    }
}
