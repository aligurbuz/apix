# Adding Dev Package
* Apix utilizes the powerfull pool system.It presents most comfort for your application
* It can be pushed any service developed in src/app/dev project in src/packages/dev/


```diff
-Any service developed in only src/app/dev can be added to dev package
- Dev package path : src/packages/dev
```

#### Creating Dev Project

```
php api project create dev

```

#### Creating Service For Dev Package In Dev Project

```
php api service create dev:sales

```

#### Adding To Dev Project

```
php api version dev development service:sales

```

# Devpack Directory In Dev Package Service (src/packages/dev).

* Devpack directory moves to this directory from migrations|model|repository that in src/app/dev/v1
* Developer can work with this directory for dev package development
* migration,model and repo is defined here automatically together with itself namespaces
* Dev package can be used for every dev project service with above command

#### How To Use Dev Package
* it is managed from servicePackageDevController that in src/app/project/versionNumber

```
 <?php
 /**
  * Service package dev file
  * it is mainly service package dev for service
  * service package dev
  */

 return [
     'packageDevSource'=>[
         'package'=>['sales'], // added sales dev package
         'packageDefinition'=>[]
     ]
 ];

```

