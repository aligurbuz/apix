<?php namespace src\packages\dev\admin\devpack\migrations\schemas\admins;

/*
 * This file is migration for model.
 *
 * model migration data
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class __1491482072__admins {

    /**
     * __1491482072__admins migration is main method.
     *
     * @return array
     */
    public static function up(){

        return "CREATE TABLE IF NOT EXISTS admins (
            id int(14) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
            username varchar(255) NOT NULL   COLLATE utf8_general_ci,
            fullname varchar(255) NOT NULL   COLLATE utf8_general_ci,
            password varchar(255) NOT NULL   COLLATE utf8_general_ci,
            status tinyint(1) NOT NULL   ,
            createdAt int(14) NOT NULL   ,
            updatedAt int(14) NOT NULL   ,
            auth longtext NOT NULL   COLLATE utf8_general_ci,
            hash varchar(255) NOT NULL   COLLATE utf8_general_ci,
            logout tinyint(1) DEFAULT \"1\"   
            ,
            UNIQUE KEY username (username),UNIQUE KEY hash (hash)
            ) ENGINE=InnoDB DEFAULT COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;";
    }

}