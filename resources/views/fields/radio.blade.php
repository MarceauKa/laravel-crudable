<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    @foreach($options as $option_key => $option_name)
    <div class="radio">
        <label for="{{ $option_name }}">
            <input type="radio" name="{{ $name }}" id="{{ $option_name }}"
                   value="{{ $option_key }}"{{ $option_key == old($name, $value) ? ' checked' : $option_key === $default_option ? ' checked' : '' }}>
            {{ $option_name }}
        </label>
    </div>
    @endforeach
    @include('crud::fields.partials.help')
    @include('crud::fields.partials.errors')
</div>
