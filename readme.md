# Laravel Crudable

[![Build Status](https://travis-ci.org/AkibaTech/laravel-crudable.svg?branch=master)](https://travis-ci.org/AkibaTech/laravel-crudable)

Laravel Crudable is a library built to **bring CRUD functionnalities to your Eloquent models**.  
At this stage it's a proof of concept and the package is not fully working...

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
                new TextField('title', 'required|min:3'),
                new TextareaField('introduction', 'required|min:3'),
                new TextareaField('content', 'required|min:3')
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
{!! $posts->table() !!}
```

Shows an edit form:
```blade
{!! $post->crud()->form() !!}
```

## Validating

**More doc is coming**

Validating data is pretty simple.

Here's an example for creation:
```php
public function create()
{
    $post = new App\Post();
    $validator = $post->crud()->validate($request->only(['title', 'introduction', 'content']));
    
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

### WIP

More fields are in progress:
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

## Screenshots

Here's some screenshots of the current example (with the default Bootstrap configuration).

Entry table:
![Entry table](https://github.com/AkibaTech/laravel-crudable/blob/master/screenshot-table.png)

Entry form:
![Entry form](https://github.com/AkibaTech/laravel-crudable/blob/master/screenshot-form.png)

## Tests

You can launch tests with
```bash
vendor/bin/phpunit
```

