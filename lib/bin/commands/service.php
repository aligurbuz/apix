<?php namespace lib\bin\commands;
use Illuminate\Database\Connectors\Connector;
use Lib\Console;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class service extends console {

    public $fileprocess;

    public function __construct(){
        parent::__construct();
        $this->fileprocess=$this->fileprocess();
        require("./lib/bin/commands/lib/getenv.php");
    }


    //service create command
    public function create ($data){

       foreach ($this->getParams($data) as $key=>$value){
           if($key==0){
               foreach ($value as $project=>$service){
                   $version=require ('./src/app/'.$project.'/version.php');
                   $version=(is_array($version) && array_key_exists('version',$version)) ? $version['version'] : 'v1';
                   $list=[];
                   if($this->mkdir(''.$project.'/'.$version.'/__call/'.$service)){

                       /*$touchReadmeParams['execution']='project_readme';
                       $touchReadmeParams['params']['projectName']=$project;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/README.md',$touchReadmeParams);*/

                       $touchServiceGetParams['execution']='services/getservice';
                       $touchServiceGetParams['params']['projectName']=$project;
                       $touchServiceGetParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/getService.php',$touchServiceGetParams);

                       $touchServicePostParams['execution']='services/postservice';
                       $touchServicePostParams['params']['projectName']=$project;
                       $touchServicePostParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/postService.php',$touchServicePostParams);

                       /*$touchServicePutParams['execution']='services/putservice';
                       $touchServicePutParams['params']['projectName']=$project;
                       $touchServicePutParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/putService.php',$touchServicePutParams);

                       $touchServicePatchParams['execution']='services/patchservice';
                       $touchServicePatchParams['params']['projectName']=$project;
                       $touchServicePatchParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/patchService.php',$touchServicePatchParams);

                       $touchServiceDeleteParams['execution']='services/deleteservice';
                       $touchServiceDeleteParams['params']['projectName']=$project;
                       $touchServiceDeleteParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/deleteService.php',$touchServiceDeleteParams);*/


                       $touchdeveloperParams['execution']='services/developer';
                       $touchdeveloperParams['params']['projectName']=$project;
                       $touchdeveloperParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/developer.php',$touchdeveloperParams);


                       $touchappParams['execution']='services/app';
                       $touchappParams['params']['projectName']=$project;
                       $touchappParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/app.php',$touchappParams);


                       $touchServiceConfParams['execution']='services/serviceConf';
                       $touchServiceConfParams['params']['projectName']=$project;
                       $touchServiceConfParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/serviceConf.php',$touchServiceConfParams);


                       //$list[]=$this->mkdir($project.'/v1/__call/'.$service.'/branches');
                       //$list[]=$this->touch($project.'/v1/__call/'.$service.'/branches/index.html',null);

                       /*$list[]=$this->mkdir($project.'/v1/__call/'.$service.'/yaml');
                       $list[]=$this->touch($project.'/v1/__call/'.$service.'/yaml/index.html',null);

                       $list[]=$this->mkdir($project.'/v1/__call/'.$service.'/yaml/expected');
                       $list[]=$this->touch($project.'/v1/__call/'.$service.'/yaml/expected/index.html',null);*/

                       /*$list[]=$this->mkdir($project.'/v1/__call/'.$service.'/interfaceObjects');
                       $list[]=$this->touch($project.'/v1/__call/'.$service.'/interfaceObjects/index.html',null);*/

                       /*$list[]=$this->mkdir($project.'/v1/__call/'.$service.'/cache');
                       $list[]=$this->touch($project.'/v1/__call/'.$service.'/cache/index.html',null);*/

                       /*$list[]=$this->mkdir($project.'/v1/__call/'.$service.'/source');
                       $list[]=$this->mkdir($project.'/v1/__call/'.$service.'/source/bundle');
                       $list[]=$this->touch($project.'/v1/__call/'.$service.'/source/bundle/index.html',null);*/


                       return $this->fileProcessResult($list,function() use($service,$project) {
                           echo $this->info('-------------------------------------------------------------------------------------------------');
                           echo $this->classical('CONGRATULATİONS! YOU HAVE CREATED A SERVICE NAMED '.$service.' IN THE '.$project.' PROJECT ');
                           echo $this->info('-------------------------------------------------------------------------------------------------');
                           echo $this->success('Request : http:ip/[-company]/service/'.$project.'/'.$service.'/index');
                           echo $this->info('--------------------------------------------------------------------------------------------------');
                       });

                   }

                   return $this->error('service fail');
               }
           }
       }

    }

    //usage : api service publish project:service names:method1/method2 http:get|post

    //service publish
    public function publish($data){
        foreach ($this->getParams($data) as $key=>$value) {
            if($key==0){


                foreach($value as $project=>$service){
                    $versionPath='./src/app/'.$project.'/version.php';

                    if(!file_exists('./src/app/'.$project.'/declaration')){
                        $this->fileprocess->mkdir_path('./src/app/'.$project.'/declaration');
                        $this->fileprocess->touch_path('./src/app/'.$project.'/declaration/index.html');
                        $this->fileprocess->mkdir_path('./src/app/'.$project.'/declaration/history');
                        $this->fileprocess->touch_path('./src/app/'.$project.'/declaration/history/index.html');
                    }
                    $version=require($versionPath);
                    if(is_array($version) && array_key_exists("version",$version)){
                        $versionNumber=$version['version'];
                    }
                    else{
                        $versionNumber='v1';
                    }

                    $servicePath='\\\\src\\\\app\\\\'.$project.'\\\\'.$versionNumber.'\\\\__call\\\\'.$service.'\\\\'.$this->getParams($data)[2]['http'].'Service';
                    //$names=explode("/",$this->getParams($data)[1]['names']);
                    $list[]=''.$servicePath.'::'.$this->getParams($data)[1]['names'].'';

                    $yamlFilePath=root.'/src/app/'.$project.'/'.$versionNumber.'/__call/'.$service.'/yaml/expected/'.$service.'_'.$this->getParams($data)[2]['http'].'_'.$this->getParams($data)[1]['names'].'.yaml';
                    if(!file_exists($yamlFilePath)){
                        return '!!! No service dump for your service';
                    }

                    $yamlFile=Yaml::parse(file_get_contents($yamlFilePath));

                    $time=time();

                    $yamlFile['publishedDate']=$time;

                    $yamlDump = Yaml::dump($yamlFile);

                    file_put_contents(root.'/src/app/'.$project.'/declaration/history/'.$service.'_'.$this->getParams($data)[2]['http'].'_'.$this->getParams($data)[1]['names'].'.yaml', $yamlDump);

                    unlink($yamlFilePath);

                    $publishPath='./src/app/'.$project.'/publish.php';
                    $publish=require($publishPath);



                    $publishedRoutes=[];
                    foreach($list as $key=>$val){
                        if(array_key_exists("service",$publish)){
                            $valpro=str_replace("\\\\","\\",$val);
                            if(!in_array($valpro,$publish['service']['name'])){
                                $publishedRoutes[]='$publishes["service"]["name"]["'.$service.'"][]="'.$val.'";';;
                            }

                        }
                        else{
                            $publishedRoutes[]='$publishes["service"]["name"]["'.$service.'"][]="'.$val.'";';
                        }

                    }

                    if(count($publishedRoutes)){
                        $dt = fopen($publishPath, "r");
                        $content = fread($dt, filesize($publishPath));
                        fclose($dt);



                        $dt = fopen($publishPath, "w");
$content=str_replace("//publishes","//publishes
".implode("
",$publishedRoutes)."",$content);

                        fwrite($dt, $content);
                        fclose($dt);

                        return 'service publish ok';
                    }
                    else{

                        return 'service available';
                    }



                }
            }
        }
    }

    //get bin params
    public function getParams($data){
        $params=[];
        foreach ($data as $key=>$value){

            $params[]=[$key=>$value];

        }

        return $params;
    }


    //set mkdir
    public function mkdir($data){

        return $this->fileprocess->mkdir($data);
    }

    //set mkdir
    public function touch($data,$param){

        return $this->fileprocess->touch($data,$param);
    }

    //mkdir process result
    public function fileProcessResult($data,$callback){

        if(count($data)==0 OR in_array(false,$data)){

            return 'service fail';
        }
        else {

            return call_user_func($callback);
        }

    }

    //get project name
    public function getProjectName($data){

        //get project name
        foreach ($data as $key=>$value){
            return $key;
        }
    }

    //file process
    public  function fileprocess(){

        //file process new instance
        $libconf=require("./lib/bin/commands/lib/conf.php");
        $file=$libconf['libFile'];
        return new $file();

    }

}