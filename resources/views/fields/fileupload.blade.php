<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <div>{!! $field->getTableValue() !!}</div>
    <input type="file" name="{{ $name }}" id="{{ $id }}" />
    @include('crud::fields.partials.help')
    @include('crud::fields.partials.errors')
</div>
