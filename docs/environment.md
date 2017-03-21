# Environment Introduce
* It means management of the environment variables.This file has extension .env or .[projectName]env
* Environment file can be created with terminal command
* Default .env.example you can copy it.
* Local management in project : .env file is created
* You can create environment file with project name (example : .[projectName]env ) -- is evaulated this file except .env


```diff
-If there is no .env file in project,Environment management is formed as production
```

#### Environment file : .env file creating via console

```
cp .env.example .env

OR

cp .env.example .[projectName]env

```

# How to identifying my environment except local.

* Identifying my environment except local
* It is in src/env as environment path
* File named env.php that in src/env is fired and environmentSetUp method is run
* the returned value is environment name (example : return 'stage'; ) --- is src/env/.stage is file

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


#### How to manage my environment in project except local.

* How to manage my environment in project except local
* It is in src/app/project_name/storage/env
* File named env.php that in src/env is fired and environmentSetUp method is run
* returned value is environment name (example : return 'stage'; ) --- is src/app/project_name/storage/env/.stage is file

