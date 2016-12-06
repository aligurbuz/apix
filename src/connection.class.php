<?php

namespace src;
use lib\config\config as config;

class connection {

    private $config;

    public function config() {
        return config::get("app");
    }
}