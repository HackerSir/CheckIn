@if($record->club)
    <a href="{{ route('clubs.show', $record->club) }}">
        {!! $record->club->display_name !!}
    </a>
@endif
