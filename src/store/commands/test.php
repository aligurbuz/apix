<?php
/*
 * This file is console command .
 * console command
 * test
 */

namespace src\store\commands;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Src\Store\Services\FileProcess as File;
use Lib\Console;

/**
 * Represents a console command example class.
 * access : api test
 * every method that on this command is called with console method as string on console
 * return type string
 */
class test extends  console {

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
        return $this->info('test command');
    }


}