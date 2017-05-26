<?php
/*
 * This file is main part of the search.
 *
 * model is called for search file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\packages\providers\search;
use Apix\Utils;
use Apix\StaticPathModel;

/**
 * Represents a search class.
 *
 * main call
 * return type array
 */

class search {


    /**
     * get construct.
     *
     */
    public function __construct(){
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function runEngineHandle($driver=null){
        if($driver===null){
            $serviceBase=staticPathModel::getAppServiceBase();
            $searchDriver=$serviceBase->search;
        }
        else{
            $searchDriver=$driver;
        }

        $search='src\store\\packages\\providers\\search\\'.$searchDriver.'\\search';
        return utils::resolve($search);
    }



}