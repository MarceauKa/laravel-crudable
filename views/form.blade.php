<h2>Entry edit</h2>
<form action="" method="POST">
    {!! csrf_field() !!}
    @foreach($entry->loopFields() as $field)
        {!! $field->form() !!}
    @endforeach
    <hr>
    <a href="#" class="btn btn-default">Back</a>
    <button class="btn btn-primary">Save</button>
</form>