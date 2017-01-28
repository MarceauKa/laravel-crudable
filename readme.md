# Laravel Crudable

[![Build Status](https://travis-ci.org/MarceauKa/laravel-crudable.svg?branch=master)](https://travis-ci.org/MarceauKa/laravel-crudable) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MarceauKa/laravel-crudable/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/MarceauKa/laravel-crudable/?branch=master) 

Laravel Crudable is a library built to bring **Custom Fields** powered **CRUD functionnalities** to **your Eloquent models**.  

## Summary

A step by step tutorial for beginners is available here: [Beginner Guide](docs/beginner_guide.md) (also available as a 3 min [video](https://youtu.be/Cb8ext3G8E0)).

- [Goals](#goals)
- [Installation](#installation)
- [Usage](#usage)
- [Fields](#fields)
- [Controller and routes](#controller-and-routes)
- [Customizing](#customizing)
- [Tests](#tests)
- [Contribute](#contribute)

## Goals

- Easy to integrate on a **new project**
- Easy to integrate to an **existing project**
- Non-intrusive API (just add a trait and one method to your model)
- Focus on fields
- Customizable
- Laravel's way

### Non-goals

- Roles or permissions
- Admin panel
 
## Installation

This version is compatible with Laravel **5.4** and **5.3**. For Laravel 5.2 compatibility see the branch **1.0**.

Install via composer:
```bash
composer require marceauka/laravel-crudable
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

Add the trait `Crudable` to your Eloquent Model, then implement the required method `getCrudFields`  

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
            // Bind the title attribute to a required Text Field.
            TextField::handle('title', 'required|min:3')->withPlaceholder('Title of the post'),
            
            // Bind the introduction attribute to a required Textarea Field.
            TextareaField::handle('introduction', 'required|min:3')->withPlaceholder('Short introduction'),
            
            // Bind the content attribute to a Tinymce Field
            TinymceField::handle('content', 'required'),
            
            // Bind the illustration attribute to a file upload allowing 10Mb JPG or PNG picture
            FileUploadField::handle('illustration')->withMaxSize(1024 * 1024)->withTypes('jpeg,png'),
            
            // Bind the status attribute to a Radio Field allowing Draft or Live options.
            RadioField::handle('status', 'required')->withOptions([0 => 'Draft', 1 => 'Live'])
        ]);
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

## Fields

Fields are the way to bind your **model attributes** to **powerful behaviors** and **reusable view components**.  

At this stage, you can use `TextField`, `TextareaField`, `RadioField`, `EmailField`, `TinymceField`, `FileUploadField`, `SelectRelationField` and `DatePickerField`, but many others are planned.

Lean more: [Fields](docs/fields.md)

## Controller and routes

By default each crudded model needs a Controller.  

You can scaffold it with the command `make:crud:controller <controller-name> <model-name>`.    
Ex: `artisan make:crud:controller PostsController Post`.

This command will generate a CRUD ready controller for your model with some scaffolded views but it's up to you to customize them.

Once generated, your need to register routes like this:
```php
// routes/web.php
App\Post::crudRoutes();
```

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
