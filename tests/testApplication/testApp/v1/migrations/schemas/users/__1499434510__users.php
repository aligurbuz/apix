<?php namespace src\app\testApp\v1\migrations\schemas\users;

/*
 * This file is migration for model.
 *
 * model migration data
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class __1499434510__users {

    /**
     * __1499434510__users migration is main method.
     *
     * @return array
     */
    public static function up(){

        return "CREATE TABLE IF NOT EXISTS users (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
            username varchar(255) NULL   COLLATE latin1_swedish_ci,
            email varchar(255) NULL   COLLATE latin1_swedish_ci,
            status int(11) NULL   ,
            createdAt int(11) NOT NULL   ,
            updatedAt int(11) NOT NULL   ,
            price float NOT NULL   
            ,KEY username_index (username)
            ,UNIQUE KEY username (username),UNIQUE KEY createdAt (createdAt)
            ) ENGINE=InnoDB DEFAULT COLLATE=latin1_swedish_ci AUTO_INCREMENT=1 ;";
    }

}