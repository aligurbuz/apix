<?php


    /*
    |--------------------------------------------------------------------------
    | Application Starting
    |--------------------------------------------------------------------------
    |
    | This class is the starter of your application. This class is used when the
    | apix firstly calls.all request coming to application are run here.
    | Apix starter place
    |
    */

    // Your custom class dir
    define('CLASS_DIR', 'config/');

    // Add your class dir to include path
    set_include_path(root.'/lib/'.CLASS_DIR);

    // You can use this trick to make autoloader look for commonly used "My.class.php" type filenames
    spl_autoload_extensions('.class.php');

    // Use default autoload implementation
    spl_autoload_register();

    require(root.'/src/connection.class.php');
