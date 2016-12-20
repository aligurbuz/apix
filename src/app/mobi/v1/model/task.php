<?php
namespace src\app\mobi\v1\model;

class task extends \src\services\db {
    //tablename
    protected $table='tasks';
    //this scope is automatically run
    //protected $scope=['auto'=>'active'];

    //scope query
    /*public static function modelScope($scope=null){
        $list['active']['status']=1;
        return $list[$scope];
    }*/
}