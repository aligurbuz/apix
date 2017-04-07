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
class doctrine {

    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function execute($data){

        $process = new Process('php vendor/bin/doctrine orm:convert-mapping --from-database php '.root.'/src/app/'.$data[2].'/'.$data[3].'/model/doctrine --force');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}