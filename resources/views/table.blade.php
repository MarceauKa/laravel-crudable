<h1>{{ $title }}</h1>

@if($is_empty === false)
    <p>
        {{ trans_choice('crud::table.count_results', $count) }}<br>
        <a href="{{ $create_url }}" class="btn btn-primary btn-xs">{{ trans('crud::buttons.create') }}</a>
    </p>

    <table class="table table-striped">
        <thead>
            <tr>
                @foreach($columns as $column)
                <th>{{ $column }}</th>
                @endforeach
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
                {!! $entry->crudEntry()->row() !!}
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-info">
        <p class="text-center">
            {{ trans_choice('crud::table.count_results', 0) }}<br>
            <a href="{{ $create_url }}" class="btn btn-primary btn-xs">{{ trans('crud::buttons.create') }}</a>
        </p>
    </div>
@endif