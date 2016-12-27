<?php
namespace src\app\__projectName__\v1\model;

class __className__ extends \src\services\db {

    //tablename
    protected $table='__tableName__';

    //data for Insert And Update And Delete
    protected static function dataForIUD() {
        $list['table']='__tableName__';
        $list['createdAndUpdatedFields']['created_at']='createdAt';
        $list['createdAndUpdatedFields']['updated_at']='updatedAt';
        return (object)$list;
    }


    //this value is run for auto paginator
    protected $paginator=['auto'=>10];

    //this value is run for auto order by desc
    protected $orderBy=['auto'=>['id'=>'desc']];

    //this value is validator for values it will be inserted
    //protected $insertedPost=[];

    //this method is auto method for values it will be inserted
    //protected static function insertedPostAttachFunction($id){}

    //this value is run for auto join type (left|inner)
    //protected $joiner=['auto'=>"left"];

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