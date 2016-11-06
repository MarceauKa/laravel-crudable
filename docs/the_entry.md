# The entry

**More doc is coming**

You can scaffold the CRUD entry in many ways:
```php
// Via helper
$crud = crud_entry(Model::class); // Or crud_table($model_instance)
// Via Facade
$crud = Crud::entry(Model::class);
// Via Factory
$crud = Akibatech\Crud\Crud::entry(Model::class)
// Via model instance
$crud = $model->crudEntry();
```

Once the entry instance in hands, the entry form displayed like this:
```blade
// In a view (powered by __toString)
{!! $crud->form() !!}
// Or like this from a model instance
{!! $model->crudEntry()->form() !!}
```

The entry instance takes care if the model should be created or updated.
