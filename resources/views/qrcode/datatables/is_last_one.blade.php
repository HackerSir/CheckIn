@if($qrcode->student)
    @if($qrcode->is_last_one)
        <i class="fa fa-check fa-2x fa-fw text-success" aria-hidden="true"></i>
    @else
        <i class="fa fa-times fa-2x fa-fw text-danger" aria-hidden="true"></i>
    @endif
@endif
