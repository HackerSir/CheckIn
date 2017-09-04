@if($record->club)
    @if(Laratrust::can('club.manage'))
        <a href="{{ route('club.show', $record->club) }}">
            {!! $record->club->display_name !!}
        </a>
    @else
        {!! $record->club->display_name !!}
    @endif
@endif
