<?php
/*
 * This file is console command .
 * console command
 * test
 */

namespace lib\bin;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Crada\Apidoc\Builder;
use Crada\Apidoc\Exception;

/**
 * Represents a console command example class.
 * access : api test
 * every method that on this command is called with console method as string on console
 * return type string
 */
class apidoc {

    /**
     * Represents a create method.
     * api test create --
     * return type string
     */
    public function handle($arguments){
        if(environment()=="local"){
            $arguments=(array)$arguments;
            foreach($arguments as $key=>$value){
                $project=$key;
            }
            $classes = array(
                'src\app\mobi\v1\__call\stk\getService',
                'src\app\mobi\v1\__call\stk\postService',
            );


            $output_dir  = root.'/external/public/';
            $output_file = 'apidoc.html'; // defaults to index.html

            try {
                $builder = new Builder($classes, $output_dir, ''.$project.'-Api Documentation', $output_file);
                $builder->generate();
            } catch (Exception $e) {
                echo 'There was an error generating the documentation: ', $e->getMessage();
            }
        }
        return null;
    }

}