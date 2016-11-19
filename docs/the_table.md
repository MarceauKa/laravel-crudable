# The table

The `CrudTable` object is used to handle a collection of `Crudable` entries.  

## Usage

Once a Crudable model in hands, you can, scaffold the CRUD table in many ways:
```php
// Via helper
$crud = crud_table(Model::class); // Or crud_table($model_instance)
// Via Facade
$crud = Crud::table(Model::class);
// Via Factory
$crud = Akibatech\Crud\Crud::table(Model::class)
// Via model instance
$crud = $model->crudTable();
```

Once the table instance in hands, it can be displayed like this:
```blade
// In a view (powered by __toString)
{!! $crud->table() !!}
// Or like this from a model instance
{!! $model->crudTable()->table() !!}
```

## API

The `CrudTable` object has for the moment no public API.
