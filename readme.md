# Laravel Crudable

Laravel Crudable is a library built to bring CRUD functionnalities to your Eloquent models.
At this stage it's a proof of concept and the package is not fully working...
 
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

## Usage

**More doc is coming**

Example model
```php
class Post extends Model
{
    use Akibatech\Crud\Crudable;

    public function getCrudFields()
    {
        return [
            new TextField('title'),
            new TextareaField('introduction'),
            new TextareaField('content')
        ];
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

## Screenshots

Here's some screenshots of the current example.

Entry table:
![Entry table](https://github.com/AkibaTech/laravel-crudable/blob/master/screenshot-table.png)

Entry form:
![Entry form](https://github.com/AkibaTech/laravel-crudable/blob/master/screenshot-form.png)