<?php
/*
 * This file is main class of the  service named stk on  mobi project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : mobi
 * namespace : src\app\mobi\v1\__call\stk
 * app class namespace : \src\app\mobi\v1\__call\stk\app
 */

namespace lib\bin;
use Symfony\Component\Console\Application;

/**
 * Represents a getService class.
 * http method : get
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class custom {

    public $request;
    public $forbidden=false;


    /**
     * index method is main method.
     * it is default method without needed interface implemantation
     * because method name is called on the url
     * method can produce ouput as string or array
     * converted to array everytime as output
     * produced json output as result
     * @return array @method
     */
    public function customConsoleApplication($data){

        //result
        $application=new Application();
        $command='\\src\\commands\\'.$data[1];
        $app=new $command();

        $list=[];
        foreach($data as $key=>$value){
            if($key>2){
                $dataEx=explode(":",$value);
                if(strlen($dataEx[1])>0){
                    $list[$dataEx[0]]=$dataEx[1];
                }
                else{
                    $list[$dataEx[0]]=null;
                }

            }
        }

        $appMethod=$data[2];
        return $app->$appMethod((object)$list);
        $application->run();
    }

    /**
     * index method is main method.
     * it is default method without needed interface implemantation
     * because method name is called on the url
     * method can produce ouput as string or array
     * converted to array everytime as output
     * produced json output as result
     * @return array @method
     */
    public function execute($data){

       return $this->customConsoleApplication($data);
    }
}