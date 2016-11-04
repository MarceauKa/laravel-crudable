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
        return CrudFields::make([
            TextField::handle('title', 'required|min:3')->withPlaceholder('Title of the post'),
            TextareaField::handle('introduction', 'required|min:3')->withPlaceholder('Short introduction to the post'),
            TextareaField::handle('content', 'required|min:3')->withPlaceholder('Your content !')->withHelp('Markdown supported!')
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
