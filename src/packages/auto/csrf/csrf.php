<?php namespace src\packages\auto\csrf;

/*
 * This file is csrf package for every service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class csrf {

    /**
     * csrf route is main method.
     *
     * @return array
     */
    public function index(){

        $session=new \src\services\httpSession();
        $token=new \src\services\httpCsrfToken();
        if($session->has("postToken")===false){
            $tokenSet=$session->set("postToken",$token->GenerateToken());
        }
        return ['postToken'=>$session->get("postToken")];
    }

}