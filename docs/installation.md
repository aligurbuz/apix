# System requirements
* php >5.6.*
* nginx or apache (for http)
* docker or vagrant container to manage terminal commands



#### Clone with writing following command on terminal to local repository the package on github

```
git clone https://github.com/aligurbuz/apix.git folderName

cd folderName

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
