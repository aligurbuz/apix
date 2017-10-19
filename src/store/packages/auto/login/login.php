<?php namespace src\store\packages\auto\login;

/*
 * This file is login package for every service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class login
{

    /**
     * login route is main method.
     *
     * @return array
     */
    public function indexAction()
    {
        //check auth
        if(auth()->persistent()===false && auth()->check()===false){

            //attempt auth
            return auth()->attempt();
        }

        //if auth is true,you logged exception
        throw new \LogicException('you are already logged');
    }
}
