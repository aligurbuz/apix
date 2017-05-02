<?php
/*
 * namespace : lib/bin/doctrine
 * doctrine class
 */

namespace lib\bin;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Represents a doctrine class.
 * http method : console
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class git {

    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function execute($data){

        $applicationPath=root.'/'.src.'/'.$this->getProject($data);

        if($this->gitInitExists($applicationPath)){
            if($this->getRemoteGitOrigin($applicationPath)){
                return true;
            }
        }
        $process = new Process('cd '.$applicationPath.' && '.$this->getCommandGit($data));
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }

    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function getCommandGit($data){

        $list=['git'];
        foreach ($data as $key=>$value){
            if($key>2){
              $list[]=$value;
            }
        }

        return implode (" ",$list);
    }


    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function gitInitExists($applicationPath){

        if(file_exists($applicationPath.'/.git')){
            return true;
        }
        return false;
    }


    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function getRemoteGitOrigin($applicationPath){

        $process = new Process('cd '.$applicationPath.' && git remote -v');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if(strlen($process->getOutput())==0){

        }
        return true;
    }

    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function getProject($data){

        return $data[2];
    }
}