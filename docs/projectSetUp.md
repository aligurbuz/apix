#### After installation,Everyting is okey to create your project now.Create first project with running the following command on terminal

```
api project create myapp

```

```diff
+ with running api project create myapp
+ it creates myapp project in src/app
+ as output : project has been created
```

## Now,create your first service in your project

```
api service create myapp:ghost

```

```diff
+ with running api service create myapp:ghost
+ it creates service named ghost in src/app/myapp/v1/__call on your myapp project
+ as output : service has been created
```

## You can see on browser your project

```
GET / http://ip/foldername/service/myapp/gost/index (called getService class in __call directory)
POST / http://ip/foldername/service/myapp/gost/index (called postService class in __call directory)

```