# Environment Introduce
* It means management of the environment variables.This file has extension .env or .[projectName]env
* Environment file can be created with terminal command
* Default .env.example you can copy it.
* Local management in project : .env file is created

```diff
-If there is no .env file in project,Environment management is formed as production
```

#### Environment file : .env file creating via console

```
cp .env.example .env

```

# How to identifying my environment except local.

* Identifying my environment except local
* It is in src/env as environment path
* File named env.php that in src/env is fired and environmentSetUp method is run
* returned value is environment name (example : return 'stage'; ) --- is .stage is file

#### environmentSetUp method in src/env/env.php

```
 /**
     * environmentSetUp for other platform method.
     *
     * @return array
     */
    public function environmentSetUp(){

        return null;
        //example
        /*if($this->request->getClientIp()='x.x.x.'){
            return 'stage';
        }*/
    }

```


#### Run following commands on terminal to use system requirements with creating project, service and database migrations. Path/to on shortcut command is network directory path

```
alias api='php /path/to/foldername/lib/bin/service'
alias migration='php /path/to/foldername/vendor/bin/phinx'

```

# What is foldername
```diff
-Foldername is your system general name or company name (directory cloned github repository).
-Every service is called from on route foldername like http://ip/foldername/service/project/servicename/index
```
