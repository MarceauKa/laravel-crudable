<h1>Posts list</h1>

@if($items->isEmpty() === false)
    <p>There's {{ $items->count() }} entries.</p>

    <table class="table table-striped">
        <thead>
            <tr>
                @foreach($fields as $field)
                <th>{{ $field->getLabel() }}</th>
                @endforeach
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                {!! $item->crud()->row() !!}
            @endforeach
        </tbody>
    </table>
@else
    <p>There's no items.</p>
@endif