@if($club->imgurImage)
    <img src="{{ $club->imgurImage->thumbnail('s') }}" class="img-thumbnail" style="width:40px; height: 40px">
@else
    <div class="img-thumbnail" style="display: inline-block; width:40px; height: 40px; vertical-align: middle"></div>
@endif
{{ $club->name }}
