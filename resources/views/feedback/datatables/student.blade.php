@if($feedback->student->is_freshman)
    <i class="fa fa-check fa-fw text-success" title="新生"></i>
@else
    <i class="fa fa-times fa-fw text-danger" title="非新生"></i>
@endif
{{ $feedback->student->display_name ?? null }}
