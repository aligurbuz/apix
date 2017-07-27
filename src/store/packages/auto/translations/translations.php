<?php namespace src\store\packages\auto\translations;

use Symfony\Component\Yaml\Yaml;

/*
 * This file is translations package for every service.
 *
 */
class translations {

    /**
     * translations route is main method.
     *
     * @return array
     */
    public function indexAction(){

        //check lang and yaml query from url
        if(\app::checkUrlParam("lang") && \app::checkUrlParam("yaml")){

            //get lang file
            $transFile=root.'/'.src.'/'.app.'/storage/lang/'.\app::getUrlParam("lang").'/'.\app::getUrlParam("yaml").'.yaml';

            //check lang file
            if(file_exists($transFile)){
                $get=Yaml::parse(file_get_contents($transFile));
                return $get;
            }
        }
        return [];
    }

}