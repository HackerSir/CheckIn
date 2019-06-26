@if($feedback->student->is_freshman)
    <i class="fa fa-check fa-fw text-success" aria-hidden="true" title="新生"></i>
@else
    <i class="fa fa-times fa-fw text-danger" aria-hidden="true" title="非新生"></i>
@endif
{{ $feedback->student->display_name ?? null }}
