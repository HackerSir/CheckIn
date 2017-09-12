@if($ticket->student)
    @if(Laratrust::can('student.manage'))
        <a href="{{ route('student.show', $ticket->student) }}">
            {{ $ticket->student->display_name }}
        </a>
    @else
        {{ $ticket->student->display_name }}
    @endif
@endif
