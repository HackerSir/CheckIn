@if($studentSurvey->student->is_freshman)
    <i class="fa fa-check fa-fw fa-2x text-success" aria-hidden="true"></i>
@else
    <i class="fa fa-times fa-fw fa-2x text-danger" aria-hidden="true"></i>
@endif
