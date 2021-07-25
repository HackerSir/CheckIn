@if($ticket->student)
    @if(Laratrust::isAbleTo('student.manage'))
        <a href="{{ route('student.show', $ticket->student) }}">
            {{ $ticket->student->display_name }}
        </a>
    @else
        {{ $ticket->student->display_name }}
    @endif
@endif
