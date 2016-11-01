<h2>{{ $title }}</h2>

<form action="{{ $manager->getActionRoute('store') }}" method="{{ $manager->getActionMethod('store') }}">
    {!! csrf_field() !!}
    @foreach($entry->fields() as $field)
        {!! $field->form() !!}
    @endforeach
    <hr>
    <a href="{{ $manager->getActionRoute('index') }}" class="btn btn-default">{{ trans('crud::buttons.back') }}</a>
    <button type="submit" class="btn btn-primary">{{ trans('crud::buttons.save') }}</button>
</form>