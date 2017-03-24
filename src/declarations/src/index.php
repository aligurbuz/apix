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
    private $loader;
    private $twig;

    /**
     * Constructor.
     * definition : class preloader with default
     * symfony component request class
     * twig template configuration
     * @param type dependency injection and function
     */
    public function __construct(){

        //get request info
        $this->request=new request();
        $this->loader = new \Twig_Loader_Filesystem(root.'/src/declarations/twigTemplate');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => root.'/src/declarations/twigTemplate/cache',
        ));
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
        $template = $this->twig->load('index.twig');
        return $template->render(array('the' => 'variables', 'go' => 'here'));

    }


}
