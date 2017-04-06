# SuDb Basic Query
* You can write sql codes very pleasant.


# Model file

```
//tablename
public $table='user';

//primary key
public $primaryKey='id';

```

#### Find Method -- primary_key is accepted 'id' as default

```
user::find(1); //SELECT * FROM user WHERE id=1;

```

#### Find Method multiple data as array

```
user::find([1,2]); //SELECT * FROM user WHERE id IN (1,2);

```

#### Find Method second key -- select fields

```
user::find(1,['id','username']); //SELECT id,username FROM user WHERE id=1;

Or

user::find([1,2],['id','username']); //SELECT id,username FROM user WHERE id IN (1,2);


```

#### Get method : it fetches as object to data-- auto paginate default value is 10 and order by is desc (by model)

```
user::get(); //SELECT * FROM user ORDER BY desc LIMIT 0,10

```


