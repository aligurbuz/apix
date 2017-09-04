<?php
namespace src;

class kernel
{

    /**
     * The bootstrap classes for the system.
     *
     * @var array
     */
    public $boot = [

        /**
         * check token via url
         */
        'Apix\Boot\CheckForToken'
    ];

}
