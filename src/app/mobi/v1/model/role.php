<?php
namespace src\app\mobi\v1\model;

class role extends \src\services\db {
    //tablename
    protected $table='prosystem_roles';

    //this value is run for auto paginator
    protected $paginator=['auto'=>10];

    //this value is run for auto order by desc
    protected $orderBy=['auto'=>['id'=>'desc']];

    //this value hiddens with password value to select field
    //protected $selectHiddenPasswordField=['password'];

    //this value hiddens  to select field
    //protected $selectHidden=['id'];

    //this scope is automatically run
    //protected $scope=['auto'=>'active'];

    //scope query
    /*public static function modelScope($scope=null){
        $list['active']['status']=1;
        return $list[$scope];
    }*/
}