<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <input name="{{ $name }}" id="{{ $id }}" class="form-control" style="max-width: 100%;"  placeholder="{{ $placeholder }}" value="{{ $value }}">
    @include('crud::fields.partials.help')
    @include('crud::fields.partials.errors')
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('input#{{ $id }}').datepicker({
            @if(!empty($date_locale))
            language: '{{ $date_locale }}',
            @endif
            todayHighlight: true,
            format: '{{ $date_format }}'
            @if(!is_null($date_min))
            ,startDate: '{{ $date_min }}'
            @endif
            @if(!is_null($date_max))
            ,endDate: '{{ $date_max }}'
            @endif
        });
    });
</script>
