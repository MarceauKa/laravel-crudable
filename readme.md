# Laravel Crudable

Laravel Crudable is a library built to bring CRUD functionnalities to your Eloquent models.
At this stage it's a proof of concept and the package is not fully working...
 
## Installation

```
composer require akibatech/laravel-crudable --dev
```

Then register the service provider in your `config/app.php`.
```
...
Akibatech\Crud\CrudServiceProvider::class
...
```

## Usage

**More doc is coming**

Example model
```
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
```
{!! $posts->table() !!}
```

Shows an edit form:
```
{!! $post->crud()->form() !!}
```