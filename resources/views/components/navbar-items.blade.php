@foreach($items as $item)
    <li@lm-attrs($item) class="nav-item @if($item->hasChildren()) dropdown @endif "@lm-endattrs>
    @if($item->link)
        <a@lm-attrs($item->link) class="nav-link @if($item->hasChildren()) dropdown-toggle @endif" @if($item->hasChildren()) data-toggle="dropdown" @endif @lm-endattrs href="{!! $item->url() !!}">
            {!! $item->title !!}
        </a>
    @else
        {!! $item->title !!}
    @endif
    @if($item->hasChildren())
        <div class="dropdown-menu">
            @include('components.navbar-subitems', ['items' => $item->children()])
        </div>
    @endif
    </li>
    {{--@if($item->divider)--}}
        {{--<li{!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>--}}
    {{--@endif--}}
@endforeach
