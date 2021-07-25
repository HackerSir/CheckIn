@if($record->student)
    @if(Laratrust::isAbleTo('student.manage'))
        <a href="{{ route('student.show', $record->student) }}">
            {{ $record->student->display_name }}
        </a>
    @else
        {{ $record->student->display_name }}
    @endif
@endif
