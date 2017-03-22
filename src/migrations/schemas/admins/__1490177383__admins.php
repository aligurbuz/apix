<?php namespace src\migrations\schemas\admins;

/*
 * This file is migration for model.
 *
 * model migration data
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class __1490177383__admins {

    /**
     * __1490177383__admins migration is main method.
     *
     * @return array
     */
    public static function up(){

        return "CREATE TABLE IF NOT EXISTS admins (
            id int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            ccode int(14) NOT NULL  ,
            username varchar(255) NOT NULL  ,
            password varchar(255) NOT NULL  ,
            email varchar(255) NULL  ,
            hash varchar(255) NOT NULL  ,
            last_hash varchar(255) NULL  ,
            fullname varchar(255) NOT NULL  ,
            last_ip varchar(255) NOT NULL  ,
            first_hash_time int(14) NULL  ,
            created_at int(11) NOT NULL  ,
            updated_at int(11) NOT NULL  ,
            photo varchar(255) NOT NULL  ,
            extra_info text NOT NULL  ,
            lang int(11) NOT NULL  ,
            user_lock int(11) NULL  ,
            role text NOT NULL  ,
            system_name varchar(255) NULL  ,
            system_number int(11) NULL  ,
            phone_number varchar(255) NULL  ,
            address text NULL  ,
            occupation varchar(255) NULL  ,
            website varchar(255) NULL  ,
            last_login_time int(11) NULL  ,
            all_time_spent int(14) NULL  ,
            hash_time_spent int(14) NULL  ,
            last_hash_time_spent int(14) NULL  ,
            all_average_time_spent_for_every_hash float NULL  ,
            all_hash_number int(14) NULL  ,
            user_where varchar(255) NULL  ,
            status int(11) NULL  ,
            logout int(2) NULL  ,
            logout_time int(14) NULL  ,
            created_by int(14) NULL  ,
            is_mobile int(14) NULL  ,
            is_tablet int(14) NULL  ,
            is_desktop int(14) NULL  ,
            is_bot int(14) NULL  ,
            browser_family char(255) NULL  ,
            os_family char(255) NULL  ,
            all_clicked int(14) NULL  ,
            hash_clicked int(14) NULL  ,
            operations int(14) NULL  ,
            success_operations int(14) NULL  ,
            fail_operations int(14) NULL  ,
            manipulation int(14) NULL  ,
            noauth_area_operations int(14) NULL  ,
            last_token char(255) NULL  ,
            last_post longtext NULL  ,
            createdAt int(14) NOT NULL  ,
            updatedAt int(14) NOT NULL  ,
            kris int(14) NOT NULL  
            
            ,UNIQUE KEY ccode (ccode)
            ) ENGINE=InnoDB DEFAULT COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;";
    }

}