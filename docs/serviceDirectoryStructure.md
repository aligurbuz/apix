# Project Directory Structure
* all services is in src/app directory
* first directory that in src/app is project name created by developer.Limitless project in directory can be created.
* the docs directory that in project contains documentation for services
* the storage directory that in project contains language files as yaml file for services
* the v1 directory that in project is version number of project.(you can see in versioning capter to version moving)
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
+ this directory structures is created the following command
```


```
api project create project_name

```



