<?php
namespace src\app\mobi\v1\model;

class user extends \src\services\sudb\model {

    //tablename
    public $table='users';

    //this value is run for auto paginator
    protected $paginator=['auto'=>10];

    //this value is run for auto order by desc
    protected $orderBy=['auto'=>['id'=>'desc']];

    //query result with this value is called from redis
    protected $redis=['status'=>false,'expire'=>60];

    //this value is validator for values it will be inserted
    //protected $insertedPost=[];

    //this value is created and updated time for values it will be inserted
    protected $createdAndUpdatedFields=['created_at'=>'createdAt','updated_at'=>'updatedAt'];

    //this method is auto method for values it will be inserted
    //protected static function insertedPostAttachFunction($id){}

    //this value is run for auto join type (left|inner)
    //protected $joiner=['auto'=>"left"];

    //this value is similar field that on the joined tables
    /*protected $joinField=['books'=>['match'=>'BookId','joinField'=>['bookname','status/bookstatus']],
        'chats'=>['hasOne'=>'userid','joinField'=>['message']]
    ];*/

    //this value hiddens  to select field
    public $selectHidden=['id'];

    //this scope is automatically run
    //protected $scope=['auto'=>'active'];

    //scope query
    public static function modelScope($scope=null){
        $list['active']['status']=1;
        return $list[$scope];
    }
}