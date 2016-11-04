<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <input type="text" class="form-control" name="{{ $name }}" id="{{ $id }}" value="{{ $old or $value }}" />
    @if($has_error)
    <p class="help-block">{{ $error }}</p>
    @endif
</div>