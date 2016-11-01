<h2>Entry edit</h2>
<form action="" method="POST">
    {!! csrf_field() !!}
    @foreach($entry->fields() as $field)
        {!! $field->form() !!}
    @endforeach
    <hr>
    <a href="#" class="btn btn-default">{{ trans('crud::buttons.back') }}</a>
    <button class="btn btn-primary">{{ trans('crud::buttons.save') }}</button>
</form>