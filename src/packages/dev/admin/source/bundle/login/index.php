<?php
/*
 * This file is bundle part of the dev service.
 *
 * every request can call one bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\packages\dev\admin\source\bundle\login;
use Src\Services\Httprequest as request;
use Src\Services\Repository as repo;

/**
 * Represents a bundle index class.
 *
 * main call
 * return type array
 */

class index extends \src\packages\dev\admin\app implements loginInterface  {

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(request $request){

        //get request info
        parent::__construct();
        $this->request=$request;

    }

    /**
     * login method is to check hash for client.
     * it calls model file
     * model update
     * @return array @method
     */
    public function get(){

        //get client's input
        $input=$this->request->input();

        //return index
        $query=$this->model->admin()->update([
            'username'=>$input['username'],
            'password'=>$input['password']
        ]);

        //get result
        return $this->getResult($query);

    }

    /**
     * get result for login method.
     * it calls query status
     * get method
     * @return string
     */
    private function getResult($query){
        if($query['queryResult']){
            return 'ok';
        }
        return 'not ok';
    }
}