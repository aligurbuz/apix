<?php
/*
 * This file is client and service extra branching of the repository service.
 *
 * client and repository info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;

/**
 * Represents a index class.
 *
 * main call
 * return type string
 */

class pipeline {


    /**
     * @var callable[]
     */
    private $stages = [];


    /**
     * get repository repo name.
     *
     * @return array
     */
    public function pipe(callable $stage){

        $pipeline = clone $this;
        $pipeline->stages[] = $stage;
        return $pipeline;
    }

    /**
     * Process the payload.
     *
     * @param $payload
     *
     * @return mixed
     */
    public function process($payload)
    {
        return $this->getResult($this->stages, $payload);
    }

    /**
     * @param array $stages
     * @param mixed $payload
     *
     * @return mixed
     */
    public function getResult(array $stages, $payload)
    {
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload);
        }
        return $payload;
    }

}
