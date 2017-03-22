# Database Migrations
* Migrations are like version control for your database, allowing your team to easily modify and share the application's database schema.
* Migrations are typically paired with project schema builder to easily build your application's database schema.
* If you have ever had to tell a teammate to manually add a column to their local database schema, you've faced the problem that database migrations solve.


# Migration Rule
```diff
-if you dont have any model for your project.You can't run pull and push command for your migrations
```

#### Pull via your models the tables existing on the database

```
api migration pull:project_name

```

#### Push in the specified database your migrations

```
api migration push:project_name

```

# Migration Seeds.

* Apix includes a simple method of seeding your database with test data using seed classes.
* All seed classes are stored in the src/app/project_name/version/migrations/seeds directory.

#### Pull your seeds via your models the tables existing in the database

```
api migration pull:project_name --seed

```

#### Push in the specified database your migration seeds

```
api migration push:project_name --seed

```