<?php
/*
 * This file is console command .
 * console command
 * test
 */

namespace lib\bin;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Represents a console command example class.
 * access : api test
 * every method that on this command is called with console method as string on console
 * return type string
 */
class migration {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createSignature = 'api test create key:value';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createDescription = '';


    /**
     * Represents a create method.
     * api test create --
     * return type string
     */
    public function handle($arguments){

        //make somethings
        $arg=$this->getArg($arguments);
        $migrationPath="\\src\\store\\packages\\providers\\migrations\\manager";
        $migration=new $migrationPath($arg);
        return $migration->handle();
    }


    /**
     * Symfony process handle.
     * new process
     * return type exec
     */
    private function getArg($arguments){
        $list=[];
        foreach($arguments as $key=>$value){
            if($key=="pull" || $key=="push"){
                $list['project']=$value;
                $list['migration']=$key;
            }
            else{
                $list[$key]=$value;
            }
        }

        return $list;

    }


    /**
     * Symfony process handle.
     * new process
     * return type exec
     */
    private function exec($arguments){

        //new process
        $process = new Process($arguments);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

}