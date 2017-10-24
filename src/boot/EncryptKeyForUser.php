<?php
namespace Src\Boot;

use Apix\Boot\EncryptKeyForUser as EncryptService;

class EncryptKeyForUser  extends EncryptService
{

    /**
     * @method boot
     */
    public function boot(){

        //for encrypt key for user
        parent::boot();
    }

}
