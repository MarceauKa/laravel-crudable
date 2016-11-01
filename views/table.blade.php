<h1>Entries list</h1>

@if($items->isEmpty() === false)
    <p>{{ trans_choice('crud::table.count_results', $items->count()) }}</p>

    <table class="table table-striped">
        <thead>
            <tr>
                @foreach($fields->columns() as $column)
                <th>{{ $column }}</th>
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
    <p>{{ trans_choice('crud::table.count_results', 0) }}</p>
@endif