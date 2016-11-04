<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $id }}" class="form-control" style="max-width: 100%;"  placeholder="{{ $placeholder }}">{!! $old or $value !!}</textarea>
    @if($help)
    <p class="help-block">{{ $help }}</p>
    @endif
    @if($has_error)
    <p class="help-block">{{ $error }}</p>
    @endif
</div>