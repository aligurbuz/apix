<?php
/*
 * namespace : lib/bin/system
 * system class
 */

namespace lib\bin;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Lib\Utils;
use Lib\StaticPathModel;
use Lib\Console;

/**
 * Represents a system class.
 * http method : console
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class system extends Console {

    private $project=null;

    /**
     * execute method is apix service system mode.
     * @return array @method
     */
    public function execute($data){
        $method=$data[3];
        $this->project=$data[2];
        return $this->$method($data);
    }

    /**
     * down method is apix service maintenance mode.
     * @return array @method
     */
    public function down($data){
        $projectPath=staticPathModel::getProjectPath($this->project);
        $downObjects=[
            'time'=>time(),
            'message'=>null,
            'downExpire'=>null
        ];

        $downPath=$projectPath.'/down.yaml';

        if(file_exists($downPath)){
            echo $this->error('Maintenance Mode! '.$this->project.' Application is now in maintenance mode.');
        }
        else{

            $result=utils::dumpYaml($downObjects,$downPath);

            if($result){
                echo $this->info('-------------------------------------------------------------------------------------------------');
                echo $this->classical('CONGRATULATİONS! '.$this->project.' Application is now in maintenance mode.');
                echo $this->info('-------------------------------------------------------------------------------------------------');
                echo $this->success('Use Up Command To Continue');
                echo $this->info('--------------------------------------------------------------------------------------------------');
            }
        }


    }


    /**
     * down method is apix service maintenance mode.
     * @return array @method
     */
    public function up($data){
        $projectPath=staticPathModel::getProjectPath($this->project);

        $downPath=$projectPath.'/down.yaml';

        if(!file_exists($downPath)){
            echo $this->error('Service Mode! '.$this->project.' Application is now in service mode.');
        }
        else{

            $result=unlink($downPath);

            if($result){
                echo $this->info('-------------------------------------------------------------------------------------------------');
                echo $this->classical('CONGRATULATİONS! '.$this->project.' Application is now in service.');
                echo $this->info('-------------------------------------------------------------------------------------------------');
            }
        }


    }
}