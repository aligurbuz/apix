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
use Lib\Console;

/**
 * Represents a getService class.
 * http method : get
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class apixlist extends console  {

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(){
        parent::__construct();
        require("./lib/bin/commands/lib/getenv.php");
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

        echo $this->info('------------------------------------------------------------------------------');
        echo $this->classical('WELCOME TO APİX COMMAND LİST ');
        echo $this->info('------------------------------------------------------------------------------');
        echo $this->blue('PHP VERSİON : '.phpversion());
        echo $this->info('------------------------------------------------------------------------------');
        echo $this->info('------------------------------------------------------------------------------');

        echo PHP_EOL;

        echo $this->success('PROJECT CREATE : ');
        echo $this->bluePrint('project create [projectName] => "create project"');
        echo $this->bluePrint('service create [projectName]:[serviceName] => "create service in project"');

        echo PHP_EOL;

        echo $this->success('SOURCE CREATE : ');
        echo $this->bluePrint('source bundle [projectName]:[serviceName] bundle:[bundleName] => "create source in project service"');
        echo $this->bluePrint('source bundle [projectName]:[serviceName] bundle:[bundleName] src:bundle => "create src source in project service"');
        echo $this->bluePrint('source bundle [projectName]:[serviceName] bundle:[bundleName] src:bundleDir/bundle => "create src source in project service"');

        echo PHP_EOL;

        echo $this->success('MODEL CREATE : ');
        echo $this->bluePrint('model create [projectName] file:[modelfilename] table:[databasetablename] => "create a model file in project"');

        echo PHP_EOL;

        echo $this->success('MIGRATION CREATE : ');
        echo $this->bluePrint('migration pull:[projectName] => "create entity for all changes from existing database in project"');
        echo $this->bluePrint('migration push:[projectName] => "create the migration push for all changes from existing database in project"');
        echo $this->bluePrint('migration pull:[projectName] --seed => "create seed for all models from existing database in project"');
        echo $this->bluePrint('migration push:[projectName] --seed => "create the migration push and seed for all changes from existing database in project"');

        echo PHP_EOL;

        echo $this->success('SYSTEM COMMANDS : ');
        echo $this->bluePrint('system [projectName] down => "create a maintenance status for all services"');
        echo $this->bluePrint('system [projectName] up => "remove from maintenance status to all services"');


        echo PHP_EOL;

        echo $this->success('SERVİCE PUBLISH : ');
        echo $this->bluePrint('service publish [projectName]:[serviceName] names:serviceNameMethod http:httpMethod   => "publish the identified service"');
        echo $this->bluePrint('service publish [projectName]:[serviceName] names:serviceNameMethod1/serviceNameMethod2 http:httpMethod   => "publish the identified service"');

        echo PHP_EOL;

        echo $this->success('VERSION MOVE : ');
        echo $this->bluePrint('version move [projectName] d:defaultVersionNumber m:movedVersionNumber=> "create a new version directory in project"');

        echo PHP_EOL;

        echo $this->success('COMMAND CREATE : ');
        echo $this->bluePrint('command create [commandName]=> "create a new command file in src/store/commands and it can be accessed via php api [commandName]"');


        echo PHP_EOL;

        echo $this->success('OTHER COMMANDS : ');
        echo $this->bluePrint('repo create [projectName] repo:repoName=> "create a new repository"');
        echo $this->bluePrint('staticprovider create [projectName] version:[versionNumber] file:staticClassName=> "create a new static provider class"');

    }
}