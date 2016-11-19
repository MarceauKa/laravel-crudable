<?php

namespace TestModel;

use Akibatech\Crud\Fields\TextField;
use Akibatech\Crud\Services\CrudFields;
use Akibatech\Crud\Traits\Crudable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Crudable;

    public function getCrudFields()
    {
        return CrudFields::make([
            TextField::handle('name', 'required')
        ]);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
