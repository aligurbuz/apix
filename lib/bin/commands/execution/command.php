<?php
/*
 * This file is console command .
 * console command
 * __class__
 */

namespace src\commands;

/**
 * Represents a console command example class.
 * access : api __class__
 * every method that on this command is called with console method as string on console
 * return type string
 */
class __class__ {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createSignature = 'api __class__ create key:value';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createDescription = '';

    /**
     * Represents a create method.
     * api __class__ create --
     * return type string
     */
    public function create($arguments){
        //make somethings
    }

}