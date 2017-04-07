<?php

namespace src\config;
use Src\Services\Httprequest as request;

class cors {

    /**
     * Symfony request.
     */
    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct(request $request){
        $this->request=$request;
    }

    /**
     * app cors.
     *
     * @app cors : conditions the app need
     * app method : symfony request utilizes
     * main loader as app method
     */
    public static function app(){

    }
}
