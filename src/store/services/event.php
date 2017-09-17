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
    public $path;

    /**
     * event constructor.
     */
    public function __construct() {

        $this->path=staticPathModel::getJobPath().'\apix';
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
        // it returns an array
        if(is_object($queue=$this->checkForTaskAccordingName($name))){

            // if queue status is true
            // queue is run
            if($queue->status){
                $this->queueRun($queue);
            }
        }

        //callback return
        return call_user_func($callback);
    }


    /**
     * @param $name
     * @return object
     */
    private function checkForTaskAccordingName($name){

        //if a task is available for name
        // boolean status true other boolean status false
        // queue param is new task
        if(class_exists($task=$this->path.'\\'.$name.'\task')){
            return (object)[
                'status'=>true,
                'queue'=>(new $task)
            ];
        }
        return (object)[
            'status'=>true
        ];
    }

    /**
     * @param $queue
     */
    private function queueRun($queue){
        dd($queue);
    }
}
