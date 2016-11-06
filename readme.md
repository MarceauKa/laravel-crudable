# Laravel Crudable

[![Build Status](https://travis-ci.org/AkibaTech/laravel-crudable.svg?branch=master)](https://travis-ci.org/AkibaTech/laravel-crudable) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AkibaTech/laravel-crudable/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/AkibaTech/laravel-crudable/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/bb03f595-0cf6-4003-bab2-9f828e8a421c/mini.png)](https://insight.sensiolabs.com/projects/bb03f595-0cf6-4003-bab2-9f828e8a421c)

Laravel Crudable is a library built to bring **Custom Fields** powered **CRUD functionnalities** to **your Eloquent models**.  

- [Goals](#goals)
- [Installation](#installation)
- [Usage](#usage)
- [Fields](#fields)
- [Customizing](#customizing)
- [Tests](#tests)
- [Contribute](#contribute)

## Goals

- Easy to integrate on a **new project**
- Easy to integrate to an **existing project**
- Non-intrusive API (just add a trait and 2 methods on your model)
- Focus on fields
- Customizable
- Laravel's way

### Non-goals

- Roles or permissions
- Admin panel
 
## Installation

Install via composer:
```bash
composer require akibatech/laravel-crudable --dev
```

Then register the service provider in your `config/app.php`.
```php
// After other service providers
Akibatech\Crud\CrudServiceProvider::class
```

Finally, publish resources:
```bash
php artisan vendor:publish --tag=crud
```

This command will publish language files and views for easy customization.

## Usage

Add the trait `Crudable` to your Eloquent Model, then implement the two required methods `getCrudFields` and `getCrudManager`.  

Example model:
```php
class Post extends Model
{
    use Crudable;
    
    /**
     * @return \Akibatech\Crud\Services\CrudFields
     */
    public function getCrudFields()
    {
        return CrudFields::make([
            // Bind the title model attribute to a TextField, 
            // with validations rules and a custom placeholder
            TextField::handle('title', 'required|min:3')->withPlaceholder('The title of the post'),
            
            // Bind the introduction model attribute to a TextareaField
            TextareaField::handle('introduction', 'required|min:3')->withPlaceholder('Short introduction to the post'),
            
            // Bind the content model attribute to a TextareaField
            TextareaField::handle('content', 'required|min:3')
                ->withPlaceholder('Your content !')
                ->withHelp('My custom help')
        ]);
    }
    
    /**
     * @return \Akibatech\Crud\Services\CrudManager
     */
    public function getCrudManager()
    {
        return CrudManager::make()
            ->setNamePrefix('posts') // All routes names begin with 'posts.'
            ->setUriPrefix('crud/posts') // All routes uris begin with 'crud/posts'
            ->setName('Post'); // Set the name of our model to be "Post"
    }
}
```

### Display the table of entries

In your controller:
```php
    public function index()
    {
        $model = App\Post::class;
        
        return view('your-view', compact($model));
    }
```

In your view:
```blade
@crudtable($model)
```

Learn more: [The Table](docs/the_table.md)

![Entry table](https://github.com/AkibaTech/laravel-crudable/blob/master/resources/screenshot-table.png)

### Display the entry create form

In your controller:
```php
    public function create()
    {
        $model = App\Post::class;
        
        return view('your-view', compact($model));
    }
    
    public function store(Request $request)
    {
        $entry = (new App\Post)->crudEntry();
        $validation = $entry->validate($request->all());
        
        if ($validation->passes())
        {
            $validation->save();
        }
        
        // Redirect to the form with the errors if validation fails, or to the index page  
        return $validation->redirect();
    }
```

In your view:
```blade
@crudentry($model)
```

Learn more: [The Entry](docs/the_entry.md)

![Entry form](https://github.com/AkibaTech/laravel-crudable/blob/master/resources/screenshot-create.png)

### Routes

If you don't have a controller with its own routes, you can scaffold them.

```php
// For example, in AppServiceProvider.php
App\Post::crudRoutes(); // Will generate routes for your Eloquent CRUD
```

Learn more: [Routes and controlllers](docs/routes_and_controllers.md)

## Fields

Fields are the way to bind your **model attributes** to **powerful behaviors** and **reusable view components**.  

At this stage, you can use `TextField` and `TextareaField`, but many are planned such as `CheckboxField`, `RadioField`, `NumberField`, `FileField`, `GoogleMapField`, `MarkdownField` and many others...

Lean more: [Fields](docs/fields.md)

## Controller

On a new project, it's handlful to scaffold your CRUD controller who is responsible of our requests and validation.

You can generate it with a new command `make:crud:controller`. Just pass to it a controller name and the name of your model.

```bash
artisan make:crud:controller PostsController Post
```

Then register the new controller to your model configuration:
```php
public function getCrudManager()
{
    return CrudManager::make()
            // ...
            ->setController(PostsController);
}
```

Then, change the view called for the table and the entry to your needs, and finally, register routes as we have seen in [Routes](#routes) section.

Learn more: [Routes and controlllers](docs/routes_and_controllers.md)

## Customizing

All views are customizable and are stored in `resources/views/vendor/crud`.

Complete documentation: [Customize Views](docs/customize_views.md)

## Tests

You can launch tests with
```bash
vendor/bin/phpunit
```

## Contribute

Feel free to contribute using issues and pull requests on this repo.

### Authors

- [Marceau Casals](https://marceau.casals.fr)

### Licence

[The MIT License (MIT)](https://opensource.org/licenses/MIT)
Copyright (c) 2016 Marceau Casals

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
