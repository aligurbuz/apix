<?php
/*
 * This file is request running of the apix system.
 * Once we have the application, we can handle the incoming request
 * through the kernel, and send the associated response back to
 * the client's browser allowing them to enjoy the creative
 * and wonderful application we have prepared for them.
 * developer : aligurbuz['sde']
 * email : galiant781@gmail.com
 * apix api services
 */

//micro time starter for apix response time
define("time_start",microtime(true));

//root definer: application root path
define("root",dirname(__FILE__));

//shortcut for src/app path
define("src","src/app");

/**
 * Apix sysmte composer vendor autoload.
 * For libraries that specify autoload information, Composer generates a vendor/autoload.php file.
 * You can simply include this file and start using the classes that those libraries provide without any extra work
 * system main skeleton
 * return autoload file
 */
require_once root.'/vendor/autoload.php';

//run the application
require_once(root.'/lib/index.php');