<?php
namespace src\store\packages\dev\apixDevPackageIllustration\devpack\model\sudb;

use Src\Store\Packages\Providers\Database\Sudb\Src\Model as Model;

class user extends Model
{
    use \src\store\packages\dev\apixDevPackageIllustration\devpack\model\modelVar;

    /**
     * @var table.
     *
     * @info table name for your database
     * @status obligatory
     */
    public $table='users';

    /**
     * @var primary key.
     *
     * @info primary key column for your database table
     * @status obligatory
     */
    public $primaryKey='id';

    /**
     * @var paginator.
     *
     * @info your result is automatically paginated
     * @status optional
     */
    public $paginator=[];

    /**
     * @var orderBy.
     *
     * @info your result is automatically ordered
     * @status optional
     */
    public $orderBy=[];

    /**
     * @var redis cache.
     *
     * @info your result is cached for redis
     * @status it is run for status true
     * @expire cache expire time
     */
    public $redis=['status'=>false,'expire'=>60];

    /**
     * @var createdAndUpdatedFields.
     *
     * @info this value is created and updated time for values it will be inserted
     * @status obligatory
     */
    public $createdAndUpdatedFields=['created_at'=>'createdAt','updated_at'=>'updatedAt'];


    /**
     * @var resultDataInfo.
     *
     * @info this value changes default result data info
     * @example coultAllData=>'total'
     * @status optional
     */
    public $resultDataInfo=[];


    /**
     * @var joiner relationship.
     *
     * @info joiner table is relationship
     * @status it is array
     * @param tableName=>['childRelation'=>'tableNameRelation']
     */
    public $joiner=[];


    /**
     * @var selectHidden.
     *
     * @info your table columns is hidden
     * @status optional
     */
    public $selectHidden=[];

    /**
     * @var insertConditions.
     *
     * @info restrictions for data inserted by client
     * @status optional - it is run for status true
     */
    public $insertConditions=[
        'status'=>false,
        'wantedFields'=>[],
        'exceptFields'=>[],
        'obligatoryFields'=>[],
        'queueFields'=>[]
    ];

    /**
     * @var updateConditions.
     *
     * @info restrictions for data updated by client
     * @status optional - it is run for status true
     */
    public $updateConditions=[
        'status'=>false,
        'wantedFields'=>[],
        'exceptFields'=>[],
        'obligatoryFields'=>[],
        'queueFields'=>[]
    ];

    /**
     * @var selectPermissions.
     *
     * @info client can select to data
     * @status optional - it is run for status true
     */
    public $selectPermissions=[
        'status'=>false,
        'authorized'=>'*',
        'forbidden'=>[],
        'tokens'=>'*',
        'seperator'=>'::'
    ];


    /**
     * @var scope.
     *
     * @info specific where conditional
     * @status optional
     */
    public $scope=['auto'=>[]];


    /**
     * @var modelScope.
     *
     * @info specific where conditional snippet
     * @status optional
     */
    public function modelScope($data, $query)
    {

        //get id
        if ($data=="id") {
            $query->where(function ($model) {
                if (\app::checkUrlParam("id")) {
                    $model->where("id", "=", \app::getUrlParam("id"));
                }
            });
        }

        //scopes
        if ($data=="active") {
            $query->where("status", "=", 1);
        }
    }

    /**
     * @var specific field .
     *
     * @info your table columns is value
     * @status optional
     */
    /*public function fieldPassword(){
        return md5(\app::post("password"));
    }*/


    public function __construct(){

        $this->resultDataInfo=$this->resultDataInfo();
        $this->paginator=$this->paginator();
        $this->orderBy=$this->orderBy();
    }
}
