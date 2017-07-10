{{ $email }}
@if (!$is_confirmed)
    <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true" title="尚未完成信箱驗證"></i>
@endif
