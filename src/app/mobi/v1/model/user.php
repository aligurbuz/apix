<?php
namespace src\app\mobi\v1\model;

class user extends \src\services\db {
    //tablename
    protected $table='users';

    //this value is run for auto paginator
    protected $paginator=['auto'=>10];

    //this value is run for auto order by desc
    protected $orderBy=['auto'=>['id'=>'desc']];

    //this value is similar field that on the joined tables
    protected $joinField=['books'=>['match'=>'BookId','joinField'=>['bookname','status/bookstatus']],
                          'chats'=>['hasMany'=>'userid','as'=>'conversations','joinField'=>['id/chat_id','message']]
                         ];

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