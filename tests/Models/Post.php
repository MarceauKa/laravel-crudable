<?php

namespace TestModel;

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
        return (new CrudFields())
            ->add([
                new TextField('title', 'required|min:3'),
                new TextareaField('introduction', 'required|min:3'),
                new TextareaField('content', 'required|min:3')
            ]);
    }

    public function getCrudManager()
    {
        return (new CrudManager())
            ->setNamePrefix('posts')
            ->setUriPrefix('crud/posts')
            ->setName('Post');
    }
}
