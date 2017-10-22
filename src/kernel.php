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

        \Apix\boot\checkForToken::class,
        \Src\Boot\VerifyCsrfToken::class
    ];

}
