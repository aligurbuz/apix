<?php
/*
 * This file is main class of the  service named stk on  mobi project .
 * METHOD : GET
 */

namespace src\commands;

/**
 * Represents a console command example class.
 * access : api example
 * every method that on this command is called with console method as string on console
 * return type string
 */
class example {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createSignature = 'api example create service:method';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createDescription = '';

    /**
     * Represents a create method.
     * api example create --
     * return type string
     */
    public function create($arguments){
        return $arguments->service;
    }

}