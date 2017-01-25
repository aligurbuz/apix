<?php
/*
 * This file is main part of the development service.
 *
 * every request is called index method as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\packages\dev\admin\branches\query\post;
use src\packages\dev\admin\devpack\admin;
use src\services\httprequest as request;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class index extends \src\packages\dev\admin\app {

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
     * index method is main method.
     *
     * @return array
     */
    public function get(){

        /**
         * get input for postdata.
         *
         * @param type array ['username','password']
         */
        $input=$this->request->input();

        /**
         * input check.
         *
         * @param type array ['username','password']
         */
        if(array_key_exists("username",$input) && array_key_exists("password",$input)){

            /**
             * user query.
             *
             * @param type query check ['username','password']
             */
            $query=admin::where("username","=",$input['username'])->where("password","=",md5($input['password']))->get();

            /**
             * check query .
             *
             * @param type bool ['true','false']
             */
            if(count($query['data'])){

                /**
                 * generate token for user.
                 *
                 * @param type string hash
                 */
                $token=''.time().'__'.md5($input['password']).'';
                return ['token'=>md5($token)];
            }
        }

        //false
        return [
            'error'=>true,
            'message'=>'user control is not valid',
            'statusCode'=>204
        ];

    }
}