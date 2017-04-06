<?php
namespace src\packages\dev\admin\devpack\model\eloquent\builder;
use src\packages\dev\admin\devpack\model\eloquent\admin;

class adminBuilder  {

    /**
     * model admin get method
     * @return array @method
     */
    public function get(){

        return admin::all();

    }


}