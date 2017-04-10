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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $command='\\src\\store\\commands\\'.$data[1];
        if($data[1]=="migration"){
            $command='\\lib\\bin\\'.$data[1];
        }

        if($data[1]=="curl"){
            $command='\\lib\\bin\\'.$data[1];
        }

        $app=\lib\utils::resolve($command);
        \lib\environment::config();

        $list=[];
        foreach($data as $key=>$value){
            if($key>1){
                $dataEx=explode(":",$value);
                if(array_key_exists(1,$dataEx) && strlen($dataEx[1])>0){
                    $list[$dataEx[0]]=$dataEx[1];
                }
                else{
                    $list[$dataEx[0]]=null;
                }

            }
        }

        return $app->handle((object)$list);
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