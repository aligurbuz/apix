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

/**
 * Represents a index class.
 *
 * main call
 * return type string
 */

class event {

    private $service=null;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(){
        $serviceBase=api.'serviceBaseController';
        $this->service=new $serviceBase();
    }

    /**
     * get dispatch method call.
     * Object-oriented code has gone a long way to ensuring code extensibility.
     * By creating classes that have well defined responsibilities, your code becomes more flexible and
     * a developer can extend them with subclasses to modify their behaviors.
     * But if they want to share the changes with other developers who have also made
     * their own subclasses, code inheritance is no longer the answer.
     *
     * @return boolean
     */
    public function dispatch($name,$callback){
        if(is_callable($callback)){
            $callData=call_user_func($callback);
            if($callData){
                $events=$this->service->event();
                $getEvent=$events[$name];
                return $getEvent();
            }
        }
        return false;
    }

}
