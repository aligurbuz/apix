<?php namespace src\packages\dev\sales\devpack\migrations\schemas\users;

/*
 * This file is migration for model.
 *
 * model migration data
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class __1490861641__users {

    /**
     * __1490861641__users migration is main method.
     *
     * @return array
     */
    public static function up(){

        return "CREATE TABLE IF NOT EXISTS users (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
            firstName varchar(255) NULL   COLLATE utf8_general_ci,
            lastName varchar(255) NULL   COLLATE utf8_general_ci,
            password varchar(255) NOT NULL   COLLATE utf8_general_ci,
            status int(2) DEFAULT \"1\"   ,
            bookId int(2) NOT NULL   ,
            createdAt int(14) NOT NULL   ,
            updatedAt int(14) NOT NULL   ,
            price int(14) NOT NULL   ,
            sales float NOT NULL   ,
            attumn tinyint(1) NOT NULL   
            
            ,UNIQUE KEY firstName (firstName,lastName)
            ) ENGINE=InnoDB DEFAULT COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;";
    }

}