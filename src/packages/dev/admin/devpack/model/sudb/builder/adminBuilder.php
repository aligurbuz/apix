<?php
namespace src\packages\dev\admin\devpack\model\sudb\builder;
use src\packages\dev\admin\devpack\model\sudb\admin;

class adminBuilder  {

    /**
     * model admin get method
     * @return array @method
     */
    public function get(){

        return admin::get();

    }

    /**
     * model admin create method
     * @return array @method
     */
    public function create($post=array()){

        //return admin::create($post);

    }

    /**
     * model admin update method
     * @return array @method
     */
    public function update($post=array()){

        return admin::where(function($query) use ($post) {

            //client post
            $query->where("username","=",$post['username']);
            $query->where("password","=",$post['password']);
            $query->where("logout","=",1);

        })->update(['hash'=>null,'logout'=>0]);

    }

    /**
     * model admin delete method
     * @return array @method
     */
    public function delete($post=array()){

        //return admin::delete($post);

    }
}