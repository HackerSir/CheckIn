@if($teaParty->club)
    <a href="{{ route('clubs.show', $teaParty->club) }}">
        {!! $teaParty->club->display_name !!}
    </a>
@endif
