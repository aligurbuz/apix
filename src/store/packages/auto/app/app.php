<?php namespace src\store\packages\auto\app;

use Apix\utils;
use Apix\staticPathModel;
use Src\Store\Services\Httprequest as Request;

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

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(Request $request)
    {

        //get app extends
        $this->request=$request;
    }

    /**
     * app route is main method.
     *
     * @return array
     */
    public function indexAction()
    {
        /**
         * app settings is an array.
         *
         * @return array
         */
        $app=[
            'app'=>[
                'app'=>app,
                'version'=>version,
                'host'=>$this->request->getHost(),
                'isSecure'=>$this->request->isSecure()
            ]

        ];


        /**
         * node settings is an array.
         *
         * @return array
         */
        $node=[
            'node'=>staticPathModel::getAppServiceBase()->nodeServiceSide()
        ];

        /**
         * array_merge for result.
         *
         * @return array
         */
        return array_merge($app,$node);
    }
}
