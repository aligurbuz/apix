# Project Directory Structure
* all services are in the src/app directory
* first directory in src/app is project name created by developer. Limitless project in directory can be created.
* the docs directory in project contains documentation for services
* the storage directory in project contains language files as yaml file for services
* the v1 directory in project is version number of project. (you can see in versioning chapter prior to version moving)
*

> Every project name can be created only once

# Version Directory Structure
* the __call directory in that version is directory including all services
* the config directory in that version includes configuration files (such as config,database vs)
* the migrations directory in that version includes database seed and migration files
* the provisions directory in that version contains object loader and general service provisions
* the staticProvider directory in that version includes autoload static classes for all services
*

> Every version name can be created only once

```diff
+ project and version directory structures is created with following command
```

```
php api project create project_name

```


# Service Directory Structure
* the directories in that __call directory are service names
* every service is created with itself structures
* the branches directory is branching for development (see branching development chapter)
* the platform directory is changing service output according to platform for development (see platform development chapter)
* app class is extended by every service.
* ready(for service) component and restrictions methoding is in app class
* developer file is an array file
* developer array is shown on service output
* getService file is file requested as http get
* every get request calls this file
* postService file is file requested as http post
* every post request calls this file
* serviceConf file is file what developer need anything (accessing as \Config::service("key"))

> Every service name can be created only once

```diff
+ service directory structures are created with the following command
```

```
php api service create project_name:service_name

```



