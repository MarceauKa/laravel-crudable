<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $id }}" class="form-control" style="max-width: 100%;">{!! $old or $value !!}</textarea>
    @if($has_error)
    <p class="help-block">{{ $error }}</p>
    @endif
</div>