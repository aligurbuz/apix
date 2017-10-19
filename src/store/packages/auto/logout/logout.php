<?php namespace src\store\packages\auto\logout;

/*
 * This file is logout package for every service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class logout
{

    /**
     * logout route is main method.
     *
     * @return array
     */
    public function indexAction()
    {
        //check auth
        if(auth()->check()){

            //logout auth
            return ['logout'=>auth()->logout()];
        }

        //if auth is false,you are not logged
        throw new \LogicException('Any logged procces is not available');
    }
}
