{{ $student->class }}
@if($student->dept_name || $student->unit_name)
    <br/>
    （{{ $student->dept_name }}／{{ $student->unit_name }}）
@endif
