<ul class="list-unstyled">
    @if($feedback->phone)
        <li class="text-nowrap"><i class="fas fa-phone fa-fw mr-2" title="電話"></i>{{ $feedback->phone }}</li>
    @endif
    @if($feedback->email)
        <li class="text-nowrap"><i class="fas fa-envelope fa-fw mr-2" title="信箱"></i>{{ $feedback->email }}</li>
    @endif
    @if($feedback->facebook)
        <li class="text-nowrap"><i class="fab fa-facebook-square fa-fw mr-2" title="Facebook"></i>{{ $feedback->facebook }}</li>
    @endif
    @if($feedback->line)
        <li class="text-nowrap"><i class="fab fa-line fa-fw mr-2" title="LINE"></i>{{ $feedback->line }}</li>
    @endif
</ul>
