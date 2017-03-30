<?php
namespace src\packages\dev\stool\devpack\model\builder;
use src\packages\dev\stool\devpack\model\user;

class userBuilder  {

    /**
     * model user get method
     * @return array @method
     */
    public function get(){

        return user::get();

    }

    /**
     * model user create method
     * @return array @method
     */
    public function create($post=array()){

        return user::create($post);

    }

    /**
     * model user update method
     * @return array @method
     */
    public function update($post=array()){

        return user::update($post);

    }

    /**
     * model user delete method
     * @return array @method
     */
    public function delete($post=array()){

        return user::delete($post);

    }
}