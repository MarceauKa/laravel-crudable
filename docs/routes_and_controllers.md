# Routes and controllers

Each `Crudable` model is managed by a `CrudManager` instance.

## Usage

By default, the `CrudManager` is automatically and basicly configured.  
This configuration comes from the `getCrudManager` on the `Crudable` trait, but you can override it.

In your model:  
```php
use Crudable;

public function getCrudManager()
{
    $manager = CrudManager::make($this);
    
    // Configuration of your manager.
    
    return $manager;
}
```

## Configuration

Many methods are available to configure the way your `Crudable` model is managed.

### Controller

```php
$manager->setController('ModelController');
```

All actions will use the `ModelController` located in the namespace `App\Http\Controllers`.

### Routes

By default all you model crud routes are:

- [Route URI] => [Route name]
- model/index => model.index
- model/create => model.create
- model/store => model.store
- model/edit/{id} => model.edit
- model/update/{id} => model.update
- model/delete/{id}/{csrf} => model.delete

Where the 'model' value is the model name, ex: `Post` => 'posts, `Category` => 'categories', ...

You can change all crud routes URI prefix like this:  
```php
$manager->setUriPrefix('admin/posts');
```

You also can change the custom prefix for the named routes:
```php
$manager->setNamePrefix('admin.posts');
```

### Name

By default the name of the crud is the name of the model, but you can configure it like this:
```php
$manager->setName('Post');
```

The name is used to display a title on the table and the form.

### Entries per page

You can customize entries displayed per page like this:
```php
$manager->setPerPage(50);
```

By default, 25 entries are displayed per page.

## Register routes

All `Crudable` model comes with a static `registerRoutes` method. 

Once routes and controller are configured, you can bind you crud model routes in your routes file like this:  
```php
// routes/web.php
Model::registerRoutes();
```

## API

The `CrudManager` instance comes with many public method.

```php
$manager = $model->getCrudManager();

// Returns the number of entries per page
// => 25
$manager->getPerPage();

// Returns the name of the CRUD
// => 'Model'
$manager->getName();

// Returns the controller
// => 'ModelController'
$manager->getController();

// Returns URL for a route
// => 'model/store'
$manager->getActionRoute('store');

// Returns needed method for a route
// => 'POST'
$manager->getActionMethod('store');

// Returns the URI prefix
// => 'model/'
$manager->getUriPrefix();

// Returns the routes name prefix
// => 'model.'
$manager->getNamePrefix();
```
