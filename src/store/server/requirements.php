<?php
/**
 * Server requirements
 * php api server | php api server [key]
 */

return [

    'node'=>[
        'sudo apt-get install -y nodejs',
        'sudo apt-get install npm',
        'sudo npm cache clean -f',
        'sudo npm install -g n',
        'sudo n stable',
        'sudo n latest'
    ]

];