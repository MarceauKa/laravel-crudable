<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    @foreach($options as $option_key => $option_name)
    <div class="radio">
        <label for="{{ $option_name }}">
            <input type="radio" name="{{ $name }}" id="{{ $option_name }}" value="{{ $option_key }}"{{ $option_key == old($name, $value) ? ' checked' : '' }}>
            {{ $option_name }}
        </label>
    </div>
    @endforeach
    @if($help)
    <p class="help-block">{{ $help }}</p>
    @endif
    @if($has_error)
    <p class="help-block">{{ $error }}</p>
    @endif
</div>
