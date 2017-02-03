<?php namespace src\packages\auto\translations;
use Symfony\Component\Yaml\Yaml;

/*
 * This file is translations package for every service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class translations {

    /**
     * translations route is main method.
     *
     * @return array
     */
    public function index(){
        if(\app::checkUrlParam("lang") && \app::checkUrlParam("yaml")){
            $transfile=root.'/'.src.'/'.app.'/storage/'.\app::getUrlParam("lang").'/'.\app::getUrlParam("yaml").'.yaml';
            if(file_exists($transfile)){
                $get=Yaml::parse(file_get_contents($transfile));
                return $get;
            }
        }
        return [];
    }

}