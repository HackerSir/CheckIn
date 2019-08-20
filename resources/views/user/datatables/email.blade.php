
@if($is_local_account)
    {{ $email }}
    @if (!$is_confirmed)
        <i class="fa fa-exclamation-triangle text-danger" title="尚未完成信箱驗證"></i>
    @endif
@else
    {{ $nid }}
@endif
