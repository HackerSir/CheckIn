@if($user->club)
    @if($user->club->clubType)
        {!! $user->club->clubType->tag !!}
    @endif
    {{ $user->club->name }}
@endif
