<?php
namespace src\app\__projectName__\v1\model;

class __className__ extends \src\services\db {
    //tablename
    protected $table='__tableName__';

    //this value is run for auto paginator
    protected $paginator=['auto'=>10];

    //this value is run for auto order by desc
    protected $orderBy=['auto'=>['id'=>'desc']];

    //this value is similar field that on the joined tables
    /*protected $joinField=['books'=>['match'=>'BookId','joinField'=>['bookname','status/bookstatus']],
        'chats'=>['hasOne'=>'userid','joinField'=>['message']]
    ];*/

    //this value hiddens with password value to select field
    //protected $selectHiddenPasswordField=['password'];

    //this value hiddens  to select field
    //protected $selectHidden=['id'];

    //this scope is automatically run
    //protected $scope=['auto'=>'active'];

    //scope query
    public static function modelScope($scope=null){
        $list['active']['status']=1;
        return $list[$scope];
    }
}