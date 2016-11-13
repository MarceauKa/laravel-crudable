# Beginner Guide - Step by Step

This guide is for beginners, we'll see the installation process from Laravel 5.3 Installation to our first entry creation.
 
## Summary

1. [Install Laravel 5.3 and Laravel Crudable](#install-laravel-53-and-laravel-crudable)
2. [Our first model and its migration](#our-first-model-and-its-migration)
3. [Configure the fields](#configure-the-fields)
4. [Configure the CRUD](#configure-the-crud)
5. [Configure views](#configure-views)
6. [Voilà!](#voilà)

## Install Laravel 5.3 and Laravel Crudable

Open a terminal and install Laravel 5.3.

```bash
composer create-project laravel/laravel crud-demo ^5.3
// Once done
cd crud-demo
```

Now, we configure database (.env), open `.env` file and replace `DB_CONNECTION=mysql` by `DB_CONNECTION=sqlite`.  
You can remove all others lines beginning with `DB_*`.  

Then type create the SQLite database.

```bash
touch database/database.sqlite
```

Install laravel-crudable.
```bash
composer require --dev akibatech/laravel-crudable @dev
```

And add it to your `config/app.php` in the `Application Service Providers` section.
```php
// ...
\Akibatech\Crud\CrudServiceProvider::class,
```

Finally, you need to publish all CRUD vendors by typing:
```
php artisan vendor:publish --tag=crud
```

Done!

## Our first model and its migration

For the demo, we'll create a crudable model `Post`. Post is like a blog entry.  
It's defined by an ID, a title, an introduction, an HTML content, an heading illustration and a status (draft, live).  
 
```bash
php artisan make:model Post -m
```

Now edit the migration file called `database/migrations/*_create_posts_table.php` and update it like this.

```php
public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->string('introduction');
        $table->string('content');
        $table->string('illustration')->nullable();
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->timestamps();
    });
}
```

Finally, type:
```
php artisan migrate
```

Done!

## Configure the fields

Open your `Post` model located at `app/Post.php` and update it like this.

```php
namespace App;

use Akibatech\Crud\Traits\Crudable;
use Akibatech\Crud\Services\CrudFields;
use Akibatech\Crud\Services\CrudManager;

use Akibatech\Crud\Fields\TextField;
use Akibatech\Crud\Fields\TextareaField;
use Akibatech\Crud\Fields\TinymceField;
use Akibatech\Crud\Fields\RadioField;
use Akibatech\Crud\Fields\FileUploadField;

use App\Http\Controllers\PostsController;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Crudable;

    public function getCrudFields()
    {
        return CrudFields::make([
            TextField::handle('title', 'required|min:3')->withPlaceholder('Title of the post'),
            TextareaField::handle('introduction', 'required|min:3')->withPlaceholder('Post introduction'),
            TinymceField::handle('content', 'required|min:3'),
            FileUploadField::handle('illustration')->withMaxSize(1024 * 1024)->withTypes('jpeg'),
            RadioField::handle('status', 'required')->withOptions([0 => 'Draft', 1 => 'Live'])
        ]);
    }
}
```

What we done on our model?

1. Added the trait `Crudable`.
2. Added the method `getCrudFields` that returns the required CrudFields instance.
3. Configured 5 fields:
    - TextField for our title
    - TextareaField for our introduction
    - TinymceField for our content
    - FileUploadField for our illustration
    - RadioField for our status
    
## Configure the CRUD

Before continue we need a Controller to handle our CRUD requests.

This package comes with a new `make:crud:controller` artisan command.

```bash
php artisan make:crud:controller PostsController App/Post
```

The first argument is the name of the controller and the second is our model name.

Now, we configure the second part of our Post model. Open it and update it like this:

```php
public function getCrudManager()
{
    return CrudManager::make()
        ->setController('PostsController')
        ->setNamePrefix('posts')
        ->setUriPrefix('posts')
        ->setPerPage(10)
        ->setName('Post');
}
```

What we done to our Post model?

1. Added the method `getCrudManager` that returns a `CrudManager` instance.
2. Configured the Controller to be our new `PostsController`.
3. Configured routes to start with `posts`.
4. Configured items per page to 10.
5. And named it `Post`

Please note that the controller creation step is optionnal because you can use your pre-existing controller but it's a good start.

Finally, open your route file located at `routes/web.php` and add:
```php
// ...
App\Post::crudRoutes();
```

## Configure views

Your CRUD is almost ready.  

Before serving your app to an HTTP server (like `artisan serve`), you need to configure 2 views.  
One for displaying the CRUD table and a second for the form view.  

It's quite simple! You just need a layout (with Bootstrap 3) and 2 views:  

The table view:  
```blade
@extends('your-layout')

@section('content')
    @crudtable('App\Post')
@endsection
```

The form view:  
```blade
@extends('your-layout')

@section('content')
    @crudentry($crud)
@endsection
```

The layout (based on the Laravel default):  
```blade
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="{{ url('css/app.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    @yield('content')
                </div>
            </div>
        </div>
        @yield('crud-styles')
        @yield('crud-scripts')
    </body>
</html>
```

Take care to the `@yield('crud-styles')` and `@yield('crud-scripts')`. You can add them where you want but they're needed.

Finally, you need to configure our generated controller to call our new views.  
Just replace `your-view` tag and your done!

## Voilà!

You can now serve your application:
```bash
php artisan serve
```

And go to `http://localhost:8000/posts/index`.
