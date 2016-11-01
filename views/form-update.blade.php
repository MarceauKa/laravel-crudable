<h2>{{ $title }}</h2>

<form action="{{ $manager->getActionRoute('update') }}" method="{{ $manager->getActionMethod('update') }}">
    {!! csrf_field() !!}
    {!! method_field($manager->getActionMethod('update')) !!}
    @foreach($entry->fields() as $field)
        {!! $field->form() !!}
    @endforeach
    <hr>
    <a href="{{ $manager->getActionRoute('index') }}" class="btn btn-default">{{ trans('crud::buttons.back') }}</a>
    <button type="submit" class="btn btn-primary">{{ trans('crud::buttons.save') }}</button>
</form>