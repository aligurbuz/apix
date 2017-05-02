<?php
/*
 * namespace : lib/bin/doctrine
 * doctrine class
 */

namespace lib\bin;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Lib\Utils;

/**
 * Represents a doctrine class.
 * http method : console
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class git {

    private $project=null;
    private $applicationPath=null;

    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function execute($data){

        $this->project=$this->getProject($data);
        $this->applicationPath=root.'/'.src.'/'.$this->project;

        if($this->gitInitExists($this->applicationPath)){
            if(!$this->getRemoteGitOrigin($this->applicationPath)){
                return false;
            }
        }
        return $this->process('cd '.$this->applicationPath.' && '.$this->getCommandGit($data));
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
        return $this->process('cd '.$this->applicationPath.' && git init','bool');
    }


    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function getRemoteGitOrigin($applicationPath){

        if(strlen($this->process('cd '.$applicationPath.' && git remote -v'))==0){
            return $this->setRemoteGitOrigin($applicationPath);
        }
        return true;
    }


    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function setRemoteGitOrigin($applicationPath){

        $getGitRepoProject=$this->getSocializeGitRepo($applicationPath);
        $getStringForRemoteAdd=$this->getStringForRemoteAdd($getGitRepoProject);

        return $this->process('cd '.$applicationPath.' && '.$getStringForRemoteAdd);
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

    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function getStringForRemoteAdd($data){

        $list=[];
        foreach ($data['remote'] as $key=>$value){
            $list[]='git remote add '.$key.' '.$data['remote'][$key]['url'].'';
        }

        return implode (' && ',$list);
    }


    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function getSocializeGitRepo($applicationPath){
        $gitRepo=utils::getAppRootNamespace($this->project).'\\config\\socialize';
        return $gitRepo::gitRepo();
    }


    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function process($command=null,$type='output'){
        if($command!==null){
            $process = new Process('cd '.$this->applicationPath.' && '.$command);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            if($type=='output'){
                return $process->getOutput();
            }
            return true;
        }

        return false;
    }


}