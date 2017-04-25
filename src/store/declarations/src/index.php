<?php
/*
 * This file is general api declaration configuration of the every service.
 *
 * config api doc returns boolean,array,string vs
 * you can't extends them because of that declarations are final class
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\declarations\src;
use src\store\services\httprequest as request;

final class index {

    public $request;
    private $loader;
    private $twig;
    private $data=array();
    private $lang='en';

    /**
     * Constructor.
     * definition : class preloader with default
     * symfony component request class
     * twig template configuration
     * @param type dependency injection and function
     */
    public function __construct(){

        //get request info
        $this->request=new request();
        $this->loader = new \Twig_Loader_Filesystem(root.'/src/store/declarations/twigTemplate/');
        $this->twig = new \Twig_Environment($this->loader, array(
            //'cache' => root.'/src/store/declarations/twigTemplate/cache',

        ));

        $this->getData();
    }

    /**
     * get declaration main function.
     * definition:index method is defined in a declaration
     * and it is called as https://ip/company/service/app/service/doc
     * @param type dependency injection and function
     * @return array
     */
    public function index(){

        //return
        /*echo '<pre>';
        print_r($this->data);
        echo '</pre>';
        exit();*/
        return $this->twig->render("index.twig",$this->data);

    }

    /**
     * get publishes main function.
     * definition:index method is defined in a declaration
     * and it is called as https://ip/company/service/app/service/doc
     * @param type dependency injection and function
     * @return array
     */
    public function getPublishes($type=null){

        //return
        $publishesPath=root.'/src/app/'.app.'/publish.php';
        $publishes=require($publishesPath);


        $list=[];
        $methods=[];

        if(array_key_exists("service",$publishes)){
            foreach ($publishes['service']['name'] as $name=>$services ){
                $list[]=$name;
                foreach ($services as $key=>$value){
                    $valueExplode=explode("\\",$value);
                    $classMethod=end($valueExplode);
                    $path=str_replace(end($valueExplode),"",$value);
                    $pathPurePath=str_replace("\\","/",$path);
                    $classMethodExplode=explode("::",$classMethod);
                    $request=str_replace("Service","",$classMethodExplode[0]);
                    $methods[$request][]=$classMethodExplode[1];
                    $yamlFile=root.'/src/app/'.app.'/declaration/history/'.$name.'_'.$request.'_'.$classMethodExplode[1].'.yaml';
                    if(file_exists($yamlFile)){
                        $methods['yaml'][]=\app::getYaml($yamlFile);
                    }
                    else{
                        $methods['yaml'][]=[];
                    }

                    $trans=root.'/src/app/'.app.'/storage/lang/'.$this->getBaseObject().'/'.$name.'_'.$request.'_'.$classMethodExplode[1].'_doc.yaml';

                    if(file_exists($trans)){
                        $this->data['trans'][]=\app::getYaml($trans);
                    }
                    else{
                        $this->data['trans'][]=[];
                    }

                }
            }
        }


        if($type=="methods"){
            return $methods;
        }


        if(count($list)){
            return $list;
        }
        return [];


    }


    /**
     * get lang main function.
     * definition:index method is defined in a declaration
     * and it is called as https://ip/company/service/app/service/doc
     * @param type dependency injection and function
     * @return array
     */
    public function getLang(){

        //return
        return \app::getYaml(root.'/src/store/storage/lang/'.$this->lang.'/doc.yaml');

    }

    /**
     * get lang main function.
     * definition:index method is defined in a declaration
     * and it is called as https://ip/company/service/app/service/doc
     * @param type dependency injection and function
     * @return array
     */
    public function getBaseObject($object='lang'){

        //return
        $baseServicePath=api.'serviceBaseController';
        $baseService=new $baseServicePath();
        return $baseService->$object;

    }

    /**
     * get lang main function.
     * definition:index method is defined in a declaration
     * and it is called as https://ip/company/service/app/service/doc
     * @param type dependency injection and function
     * @return array
     */
    public function getQuery($param=null){

        //return
        if($param===null){
            return $this->request->getQueryString();
        }
        return $this->request->getQueryString($param);


    }


    /**
     * get data main function.
     * definition:index method is defined in a declaration
     * and it is called as https://ip/company/service/app/service/doc
     * @param type dependency injection and function
     * @return array
     */
    public function getData(){

        //return
        $this->data['root']=basePath;
        $this->data['app']=app;
        $this->data['appHeader']=ucfirst(app);
        $this->data['lang']=$this->getLang();
        $this->data['services']=$this->getPublishes();
        $this->data['methods']=$this->getPublishes('methods');
        $this->data['getService']=$this->request->getQueryString('service');
        if(\app::checkToken()){
            $this->data['token']='&_token='.$this->getQuery('_token');
        }
        else{
            $this->data['token']='';
        }

        if(\app::checkUrlParam('service')){
            $this->data['reverse']=array_search(\app::getUrlParam('service'),$this->data['services']);
        }
        else{
            $this->data['reverse']=null;
        }




    }


}
