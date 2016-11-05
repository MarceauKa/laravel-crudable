# Laravel Crudable

[![Build Status](https://travis-ci.org/AkibaTech/laravel-crudable.svg?branch=master)](https://travis-ci.org/AkibaTech/laravel-crudable) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AkibaTech/laravel-crudable/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/AkibaTech/laravel-crudable/?branch=master)

Laravel Crudable is a library built to **bring CRUD functionnalities to your Eloquent models**.  
At this stage it's a proof of concept and the package is not fully working...

- [Goals](#goals)
- [Installation](#installation)
- [Usage](#usage)
- [Validating](#validating)
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

**More doc is coming**

### Basic example

Example model
```php
use Akibatech\Crud\Fields\TextareaField;
use Akibatech\Crud\Fields\TextField;
use Akibatech\Crud\Services\CrudFields;
use Akibatech\Crud\Services\CrudManager;
use Akibatech\Crud\Traits\Crudable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Crudable;

    public function getCrudFields()
    {
        return CrudFields::make([
            TextField::handle('title', 'required|min:3')
                ->withPlaceholder('The title of the post'),
            TextareaField::handle('introduction', 'required|min:3')
                ->withPlaceholder('Short introduction to the post'),
            TextareaField::handle('content', 'required|min:3')
                ->withPlaceholder('Your content !')
                ->withHelp('My custom help')
        ]);
    }
    
    public function getCrudManager()
    {
        return CrudManager::make()
            ->setNamePrefix('posts')
            ->setUriPrefix('crud/posts')
            ->setName('Post');
    }
}
```

Shows the table (on a model collection):
```blade
{!! $posts->crudTable() !!}
```

Shows an edit form:
```blade
{!! $post->crudEntry() !!}
```

Routes scaffolding:
```php
// For example, in AppServiceProvider.php
App\Post::crudRoutes(); // Will generate routes for your Eloquent CRUD
```

### The table

![Entry table](https://github.com/AkibaTech/laravel-crudable/blob/master/resources/screenshot-table.png)

You can scaffold the CRUD table in many ways:
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

### The entry

![Entry form](https://github.com/AkibaTech/laravel-crudable/blob/master/resources/screenshot-create.png)

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

## Validating

**More doc is coming**

Validating data is pretty simple.

Here's an example for creation:
```php
public function create()
{
    $validator = Crud::entry(Post::class)
                    ->validate($request->only(['title', 'introduction', 'content']));
    
    if ($validator->passes()) {
        $validator->save();
    }
    
    return $validator->redirect();
}
```

## Fields

**More doc is coming**

### Implemented

Actually there's 2 fields implemented:
- TextField: A basic text input
- TextareaField: A basic textarea input

### Planned

More fields are planned:
- CheckboxField
- RadioField
- PasswordField
- RangeField
- NumberField
- GoogleMapField
- FileField
- MultiFileField
- DropzoneField
- TwitterField
- UrlField
- ImageField
- MarkdownField
- WysiwygField
- ...and many more

## Customizing

All views are customizable and are stored in `resources/views/vendor/crud`. Here's the details:

### Table view `table.blade.php`

- `$create_url` URL to the create form
- `$title` Title of the table
- `$count` Entries count
- `$is_empty` Empty or not?
- `$entries` Entries collection. Each entries calls the row view
- `$columns` An array containing names of columns

### Row view `row.blade.php`

- `$entry` The CrudEntry instance
- `$manager` The manager (descriptions is coming)
- `$actions` The entry buttons (not customizable yet)

### Form view `form-create.blade.php` and `form-update.blade.php`

- `$back_url` URL to the index view
- `$entry` CrudEntry instance itself
- `$errors` Validation errors
- `$old` Old inputs values
- `$title` Form title
- `$form_url` Form action URL
- `$form_method` Form method
- and more...

### Field view `fields/*.blade.php`

Each view is named by its field.  
Ex: `fields/text.blade.php` for the `TextField`.

- `$field` Field instance itself 
- `$error` Validation error for the field 
- `$old` Old value for the field 
- and more...

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