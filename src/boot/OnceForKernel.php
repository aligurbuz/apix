<?php
namespace Src\Boot;

use Apix\Boot\OnceForKernel as OnceService;

class OnceForKernel extends OnceService
{

    /**
     * @method boot
     */
    public function boot(){

        //write once class for kernel
        parent::boot();
    }

}
