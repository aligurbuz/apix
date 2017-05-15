<?php


    //load spl autoload register
    require_once(root.'/lib/spl_autoload_register.php');

    //get connection
    echo \lib\connection::run();
