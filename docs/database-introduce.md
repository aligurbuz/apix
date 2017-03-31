# Database Introduce
* In the following article we will learn a few things about ORM frameworks:

  * What they are.
  * What they do.
  * When and why to use them.
  * And finally, what ORM options PHP’ers have.




#### Container usage

```
public function () {
    //it checks user device
    return \Container::device()->isMobile();
}

```

#### App helper method usage

```
public function () {
    //it checks user device
    return app("device")->isMobile();
}

```


# Company specific container class
* src/app/config.php

# Project specific container class
* src/app/project_name/version/config/app.php
