<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-control">
        @foreach($options as $option_key => $option_value)
            <option value="{{ $option_key }}">{{ $option_value }}</option>
        @endforeach
    </select>
    @include('crud::fields.partials.help')
    @include('crud::fields.partials.errors')
</div>
