@foreach($items as $item)
    @if($item->link)
        <a @lm_attrs($item->link) class="dropdown-item" @lm_endattrs href="{!! $item->url() !!}">
            {!! $item->title !!}
        </a>
    @else
        {!! $item->title !!}
    @endif
    {{--@if($item->hasChildren())--}}
    {{----}}
    {{--@endif--}}
    @if($item->divider)
        <div class="dropdown-divider"></div>
    @endif
@endforeach
