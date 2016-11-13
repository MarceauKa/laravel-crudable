<h1>{{ $title }} <a href="{{ $create_url }}" class="btn btn-primary btn-xs">{{ trans('crud::buttons.create') }}</a></h1>

@if($is_empty === false)
    <p>
        {{ trans_choice('crud::table.count_results', $count) }}<br>
    </p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
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
    </div>

    {!! $pagination->links() !!}
@else
    <div class="alert alert-info">
        <p class="text-center">
            {{ trans_choice('crud::table.count_results', 0) }}<br>
            <a href="{{ $create_url }}" class="btn btn-primary btn-xs">{{ trans('crud::buttons.create') }}</a>
        </p>
    </div>
@endif
