# Environment Introduce
* It means management of the environment variables.This file has extension .env or .[projectName]env
* Environment file can be created with terminal command
* Default .env.example you can copy it.
* Local management in project : .env file is created

# if there is no .env file in project
```diff
Environment management is formed as production
```



#### .env file creating via console

```
cp .env.example .env

```

#### Please update it for your composer to use vendor system because of that the apix system utilizes Composer to manage its dependencies.

```
composer update

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
