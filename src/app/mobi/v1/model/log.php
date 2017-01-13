<?php
namespace src\app\mobi\v1\model;

class log extends \src\services\sudb\model {

    //tablename
    public $table='prosystem_administrator_process_logs';

    //this value is run for auto paginator
    public $paginator=['auto'=>10];

    //this value is run for auto order by desc
    public $orderBy=['auto'=>['id'=>'desc']];

    //query result with this value is called from redis
    public $redis=['status'=>false,'expire'=>60];

    //this value is created and updated time for values it will be inserted
    public $createdAndUpdatedFields=['created_at'=>'createdAt','updated_at'=>'updatedAt'];

    //this value is run for auto join type (left|inner)
    //protected $joiner=['auto'=>"left"];

    //this value is similar field that on the joined tables
    /*protected $joinField=['books'=>['match'=>'BookId','joinField'=>['bookname','status/bookstatus']],
        'chats'=>['hasOne'=>'userid','joinField'=>['message']]
    ];*/

    //this value hiddens  to select field
    //public $selectHidden=['id'];

    //this scope is automatically run
    //public $scope=['auto'=>'active'];

    //scope query
    public static function modelScope($scope=null){
        $list['active']['status']=1;
        return $list[$scope];
    }

    //insert conditions
    public $insertConditions=[
        'status'=>false,
        'wantedFields'=>[],
        'exceptFields'=>[],
        'obligatoryFields'=>[],
        'queueFields'=>[]
    ];
}