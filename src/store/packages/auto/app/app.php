<?php namespace src\store\packages\auto\app;

/*
 * This file is app package for every service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class app
{

    /**
     * app route is main method.
     *
     * @return array
     */
    public function index()
    {
        return [
            'application'=>app,
            'version'=>version
        ];
    }
}
