# SuDb Basic Query
* You can write sql codes very pleasant.


#### Find Method -- primary_key is accepted 'id' as default

# Model file

```
    //tablename
    public $table='admins';

    //primary key
    public $primaryKey='id';

```


```
user::find(1); //SELECT * FROM user WHERE id=1;

```


