<?php
/**
 * Cli composer vendor autoload.
 * For libraries that specify autoload information, Composer generates a vendor/autoload.php file.
 * You can simply include this file and start using the classes that those libraries provide without any extra work
 * system main skeleton
 * return autoload file
 */
require_once './vendor/autoload.php';

/**
 * Spl auto load register.
 * spl_autoload_register — Register given function as __autoload() implementation
 * Register a function with the spl provided __autoload queue. If the queue is not yet activated it will be activated.
 * If your code has an existing __autoload() function then this function must be explicitly registered on the __autoload queue.
 * This is because spl_autoload_register() will effectively replace the engine cache for the __autoload() function
 * by either spl_autoload() or spl_autoload_call()
 * return autoload
 */
require_once(root.'/lib/spl_autoload_register.php');
require (''.\Apix\staticPathModel::$apixClassAliasPath.'');
\Apix\environment::config();

