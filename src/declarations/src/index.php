<?php
/*
 * This file is general api doc configuration of the every service.
 *
 * config app returns boolean,array,string vs
 * access : for example \app::environment()
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\declarations\src;
use src\services\httprequest as request;

class index {

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
     * get container.
     * definition:classess is defined in a container
     * and it is called as app("device")->method()
     * @param type dependency injection and function
     * @return array
     */
    public function main(){

        //return
        return 'hello api';

    }


}
