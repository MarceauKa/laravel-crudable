<tr>
    @foreach($entry->fields() as $field)
    <td>{!! $field->getTableValue() !!}</td>
    @endforeach
    <td>
        @foreach($actions as $action)
        <a href="{{ $action['uri'] }}" class="{{ $action['class'] }}">{{ $action['value'] }}</a>
        @endforeach
    </td>
</tr>
