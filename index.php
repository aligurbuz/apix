<?php
/*
 * This file is request running of the apix system.
 *
 * every service calls this file file as default
 * developer : aligurbuz['sde']
 * email : galiant781@gmail.com
 * apix api services
 */
define("time_start",microtime(true));
define("root",dirname(__FILE__));
define("src","src/app");
require_once root.'/vendor/autoload.php';
require_once(root.'/lib/index.php');