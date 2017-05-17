<?php namespace src\store\packages\auto\csrf;

use src\store\services\httpCsrfToken as csrfToken;

/*
 * This file is csrf package for every service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class csrf {

    private $session;

    /**
     * csrf route construct
     * session initialize.
     *
     */
    public function __construct(){
        $this->session=app("session");
    }

    /**
     * csrf route is main method.
     *
     * @return array
     */
    public function index(){

        //check session for postToken
        if($this->session->has("postToken")===false){
            $token=new csrfToken();
            $tokenSet=$this->session->set("postToken",$token->GenerateToken());
        }
        return ['postToken'=>$this->session->get("postToken")];
    }

}