<?php
namespace src\app\testApp\v1\model\sudb\adapter;

use src\app\testApp\v1\model\sudb\builder\userBuilder;
use src\app\testApp\v1\model\sudb\user;

class userAdapter
{

    public $builder;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(userBuilder $builder){

        $this->builder=$builder;
    }

    /**
     * model user get method
     * @return array @method
     */
    public function get()
    {
        return $this->builder->get();
    }

    /**
     * model user create method
     * @return array @method
     */
    public function create($post=array())
    {
        return $this->builder->create($post);
    }

    /**
     * model user update method
     * @return array @method
     */
    public function update($post=array())
    {
        return $this->builder->update($post);
    }

    /**
     * model user delete method
     * @return array @method
     */
    public function delete($post=array())
    {
        return $this->builder->delete($post);
    }
}
