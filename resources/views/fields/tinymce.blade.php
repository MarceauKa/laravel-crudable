<div class="form-group{{ $has_error ? ' has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $id }}" class="form-control" style="max-width: 100%;"  placeholder="{{ $placeholder }}">{!! $old or $value !!}</textarea>
    @include('crud::fields.partials.help')
    @include('crud::fields.partials.errors')
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        tinymce.init({
            selector: 'textarea#{{ $id }}',
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap anchor',
                'searchreplace visualblocks code fullscreen media table contextmenu paste code'
            ],
            toolbar: 'fullscreen undo redo | styleselect table | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            statusbar: false,
            menubar: false
        });
    });
</script>
