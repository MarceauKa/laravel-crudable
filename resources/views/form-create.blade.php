<h1>{{ $title }}</h1>

<form action="{{ $form_url }}" method="{{ $form_method }}"{!! $multipart !!}>
    {!! $method_field !!}
    {!! $csrf_field !!}
    @foreach($entry->formFields() as $field)
        {!! $field->form() !!}
    @endforeach
    <hr>
    <a href="{{ $back_url }}" class="btn btn-default">@lang('crud::buttons.back')</a>
    <button type="submit" class="btn btn-primary">@lang('crud::buttons.save')</button>
</form>
@include('crud::fields.assets', compact($crud_js, $crud_css))