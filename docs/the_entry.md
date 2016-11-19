# The entry

The `CrudEntry` object is used to handle an instance of `Crudable` entry.  

## Usage

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

## API

The `CrudEntry` object comes with useful methods described here:

```php
$entry = App\Model::findOrFail(1)->crudEntry();

// Returns a validator ready (CrudValidator) to handle the entry.
$validator = $entry->getValidator();

// Validate an array of data. Returns a CrudValidator instance.
$validator = $entry->validate(['title' => 'Foo', '...']);

// Save the entry to database (only if there's dirty attributes).
$entry->save();

// Returns all visible fields in a Generator.
$entry->fields();

// Returns all fields in a Generator.
$entry->formFields();

// Returns the model ID (primary key).
$entry->getId();

// Returns the entry row. It's the template used to display the entry in the table.
$entry->row();

// Returns the CrudManager instance
$manager = $entry->getManage();

// Returns the CrudFields instance
$entry->getFields();

// Returns the original model.
$entry->getModel();
```
