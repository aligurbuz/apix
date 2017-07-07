<?php namespace src\app\testApp\v1\model;

trait modelVar {

    /**
     * @var orderBy.
     *
     * @info your result is automatically ordered
     * @status optional
     * @return array
     */
    public function orderBy(){

        return [
            'auto'=> [
                    'id'=>'desc'
                ]
        ];
    }

    /**
     * @var paginator.
     *
     * @info your result is automatically paginated
     * @status optional
     * @return array
     */
    public function paginator(){

        return [
            'auto'=>10
        ];
    }

    /**
     * @var resultDataInfo.
     *
     * @info this value changes default result data info
     * @example coultAllData=>'total'
     * @status optional
     * @return array
     */
    public function resultDataInfo(){

        return [];
    }
}