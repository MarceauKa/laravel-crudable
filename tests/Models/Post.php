<?php

namespace TestModel;

use Akibatech\Crud\Fields\TextareaField;
use Akibatech\Crud\Fields\TextField;
use Akibatech\Crud\Services\CrudFields;
use Akibatech\Crud\Services\CrudManager;
use Akibatech\Crud\Traits\Crudable;
use App\Http\Controllers\PostsController;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @package App
 */
class Post extends Model
{
    use Crudable;

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  CrudFields
     */
    public function getCrudFields()
    {
        $fields = [
            new TextField('title', 'required|min:3'),
            new TextareaField('introduction', 'required|min:3'),
            new TextareaField('content', 'required|min:3')
        ];

        return (new CrudFields())->add($fields);
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  CrudManager
     */
    public function getCrudManager()
    {
        return (new CrudManager())
            ->setNamePrefix('posts')
            ->setUriPrefix('crud/posts')
            ->setName('Post');
    }
}
