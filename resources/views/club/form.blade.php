{{ bs()->formGroup(bs()->text('number')->placeholder('如：A66'))->label('社團編號')->showAsRow() }}
{{ bs()->formGroup(bs()->text('name')->placeholder('如：黑客社')->required())->label('名稱')->showAsRow() }}
{{ bs()->formGroup(bs()->select('club_type_id')->options(\App\ClubType::selectOptions()))->label('社團類型')->showAsRow() }}
{{ bs()->formGroup(bs()->textarea('description')->attribute('rows', 10))->label('描述')->showAsRow() }}
{{ bs()->formGroup(bs()->textarea('extra_info')->attribute('rows', 10))->label('額外資訊')->helpText('僅限對此社團填寫回饋資料的學生檢視，可放FB社團、LINE群網址等')->showAsRow() }}
{{ bs()->formGroup(bs()->input('url', 'url')->placeholder('網站、粉絲專頁等'))->label('網址')->showAsRow() }}

@if(isset($club) && $club->imgurImage)
    <div class="form-group row">
        <label for="image_file" class="col-md-2 col-form-label">圖片</label>
        <div class="col-md-10">
            <p class="form-control-plaintext">
                <img src="{{ $club->imgurImage->thumbnail('t') }}">
                <a href="{{ $club->imgurImage->url }}" target="_blank">
                    {{ $club->imgurImage->file_name }}
                </a>
            </p>
            <small class="form-text text-muted">
                若不更換圖片，下欄請留空
            </small>
        </div>
    </div>
@endif

{{ bs()->formGroup(bs()->simpleFile('image_file')->acceptImage())->label('圖片上傳')
->helpText('檔案大小限制：'. app(\App\Services\FileService::class)->imgurUploadMaxSize())->showAsRow() }}
{{ bs()->formGroup(bs()->select('booth_id[]')->attributes(['id' => 'booth_id', 'multiple']))->label('攤位')->showAsRow() }}
{{ bs()->formGroup(bs()->select('user_id[]')->attributes(['id' => 'user_id', 'multiple']))->label('攤位負責人')->showAsRow() }}

@section('js')
    @parent
    <script>
        $(function () {
            function formatTemplateBooth(booth) {
                if (booth.loading) return booth.text;
                if (!booth.name) return null;

                var markup = "<div class='container' style='width: 100%'><div class='row'>"
                    + "<div class='col-md-12'>" + booth.name + "<br/></div>"
                    + "</div></div>";

                return markup;
            }

            function formatTemplateUser(user) {
                if (user.loading) return user.text;
                if (!user.name) return null;

                var markup = "<div class='container' style='width: 100%'><div class='row'>"
                    + "<div class='col-md-1'><img src='" + user.gravatar + "' /></div>"
                    + "<div class='col-md-11'>" + user.name + "<br/><small>" + user.email + "</small></div>"
                    + "</div></div>";

                return markup;
            }

            function formatTemplateSelection(item) {
                return item.name || item.text;
            }

            var $boothSelect = $('#booth_id');
            var selectedBooth = {!! isset($club) ? $club->booths->pluck('name','id')->toJson() : '{}' !!};
            var selectedBoothIds = {!! isset($club) ? $club->booths->pluck('id')->toJson() : '{}' !!};
            var initialBooths = [];
            $.each(selectedBooth, function (key, val) {
                initialBooths.push({id: key, text: val});
            });
            $boothSelect.select2({
                tags: true,
                tokenSeparators: [',', ' '],
                data: initialBooths,
                ajax: {
                    url: '{{ route('api.booth-list') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': window.Laravel.csrfToken,
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            club: {{ $club->id ?? 0 }}
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: params.page < data.last_page
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                templateResult: formatTemplateBooth, // omitted for brevity, see the source of this page
                templateSelection: formatTemplateSelection // omitted for brevity, see the source of this page
            });
            $boothSelect.val(selectedBoothIds).trigger('change');

            var $userSelect = $('#user_id');
            var selectedUser = {!! isset($club) ? $club->users->pluck('name','id')->toJson() : '{}' !!};
            var selectedUserIds = {!! isset($club) ? $club->users->pluck('id')->toJson() : '{}' !!};
            var initialUsers = [];
            $.each(selectedUser, function (key, val) {
                initialUsers.push({id: key, text: val});
            });
            $userSelect.select2({
                tags: true,
                tokenSeparators: [',', ' '],
                data: initialUsers,
                ajax: {
                    url: '{{ route('api.user-list') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': window.Laravel.csrfToken,
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            club: {{ $club->id ?? 0 }}
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: params.page < data.last_page
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                templateResult: formatTemplateUser, // omitted for brevity, see the source of this page
                templateSelection: formatTemplateSelection // omitted for brevity, see the source of this page
            });
            $userSelect.val(selectedUserIds).trigger('change');
        });
    </script>
@endsection
