@section('crud-styles')
    @parent
    @foreach($crud_css as $file)
        <link rel="stylesheet" href="{{ url($file) }}">
    @endforeach
@endsection

@section('crud-scripts')
    @parent
    @foreach($crud_js as $file)
        <script src="{{ url($file) }}"></script>
    @endforeach
@endsection
