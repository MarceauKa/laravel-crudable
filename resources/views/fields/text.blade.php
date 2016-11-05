<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <input type="text" class="form-control" name="{{ $name }}" id="{{ $id }}" value="{{ $old or $value }}" placeholder="{{ $placeholder }}" />
    @if($help)
    <p class="help-block">{{ $help }}</p>
    @endif
    @if($has_error)
    <p class="help-block">{{ $error }}</p>
    @endif
</div>
