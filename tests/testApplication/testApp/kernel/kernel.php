<?php
namespace src\app\testApp\kernel;

class Kernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    public $middleware = [];


    /**
     * The application's global class loaders.
     *
     * These service loc containers can be changed by user.
     *
     * @var array
     */
    public $serviceLocContainer = [
        '\Apix\ResponseManager'=>'\Apix\ResponseManager'
    ];


    /**
     * The application's global class loaders.
     *
     * These service loc containers can be changed by user.
     * @using console param ; 'service create' =>'stubsClass'
     * @var array
     */
    public $stubsForGenerator = [];


    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    public $bootstrappers = [];


    /**
     * The Process component executes commands in sub-processes.
     * The component takes care of the subtle differences between the different platforms when executing the command.
     * @access php api runner mobi
     *
     * @return array
     */
    public $commandProcessRunner = [
        'mixed'=>[
            'ls -la'
        ]
    ];

}
