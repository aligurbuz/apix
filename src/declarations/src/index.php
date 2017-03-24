<?php
/*
 * This file is general api declaration configuration of the every service.
 *
 * config api doc returns boolean,array,string vs
 * you can't extends them because of that declarations are final class
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\declarations\src;
use src\services\httprequest as request;

final class index {

    public $request;

    /**
     * Constructor.
     * definition : class preloader with default
     * symfony component request class
     * @param type dependency injection and function
     */
    public function __construct(){

        //get request info
        $this->request=new request();
    }

    /**
     * get declaration main function.
     * definition:index method is defined in a declaration
     * and it is called as https://ip/company/service/app/service/doc
     * @param type dependency injection and function
     * @return array
     */
    public function index(){

        //return
        return 'hello api';

    }


}
