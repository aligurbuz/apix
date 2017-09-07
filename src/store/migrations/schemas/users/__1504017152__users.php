<?php namespace src\store\migrations\schemas\users;

/*
 * This file is migration for model.
 *
 * model migration data
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class __1504017152__users {

    /**
     * __1504017152__users migration is main method.
     *
     * @return string
     */
    public static function up(){

        return "CREATE TABLE IF NOT EXISTS users (
            id int(6) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
            username varchar(30) NOT NULL   COLLATE latin1_swedish_ci,
            password varchar(30) NOT NULL   COLLATE latin1_swedish_ci,
            email varchar(50) NULL   COLLATE latin1_swedish_ci,
            createdAt int(14) NULL   ,
            updatedAt int(14) NULL   
            
            
            ) ENGINE=InnoDB DEFAULT COLLATE=latin1_swedish_ci AUTO_INCREMENT=1 ;";
    }

}