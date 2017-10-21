<?php namespace src\store\packages\auto\login;

class login
{

    /**
     * login route is main method.
     *
     * @return array
     */
    public function indexAction()
    {
        //check auth
        if(auth()->persistent()===false && auth()->check()===false){

            //attempt auth
            if(auth()->attempt()!==false){

                return [
                    'result'=>auth()->getToken()
                ];
            }
            throw new \InvalidArgumentException('Incorrect credentials');
        }

        //if auth is true,you logged exception
        throw new \LogicException('you are already logged');
    }
}
