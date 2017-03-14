#### After installation, it is okay to create your project now. Create first project by running the following command on terminal

```
api project create myapp

```

```diff
+ with running api project create myapp
+ it creates myapp project in src/app
+ output : project has been created
```

## Now, create your first service in your project

```
api service create myapp:ghost

```

```diff
+ with running api service create myapp:ghost
+ it creates service named ghost in src/app/myapp/v1/__call on your myapp project
+ output : service has been created
```

## You can see your project on browser

```
GET / http://ip/foldername/service/myapp/gost/index (called getService class in __call directory)
POST / http://ip/foldername/service/myapp/gost/index (called postService class in __call directory)

```
