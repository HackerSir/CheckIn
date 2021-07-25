{{ bs()->formGroup(bs()->text('number')->placeholder('如：A66'))->label('社團編號')->showAsRow() }}
{{ bs()->formGroup(bs()->text('name')->placeholder('如：黑客社')->required())->class('required')->label('名稱')->showAsRow() }}
{{ bs()->formGroup(bs()->select('club_type_id')->options(\App\Models\ClubType::selectOptions()))->label('社團類型')->showAsRow() }}
<hr/>
{{ bs()->formGroup(bs()->textarea('description')->attribute('rows', 10)->class('tinymce'))->label('描述')->showAsRow() }}
{{ bs()->formGroup(bs()->textarea('extra_info')->attribute('rows', 10)->class('tinymce'))->label('額外資訊')->helpText('僅限對此社團填寫回饋資料的學生檢視，可放FB社團、LINE群網址等')->showAsRow() }}
{{ bs()->formGroup(bs()->input('url', 'url')->placeholder('網站、粉絲專頁等'))->label('網址')->showAsRow() }}

@if(isset($club) && $club->imgurImage)
    <div class="form-group row">
        <label for="image_file" class="col-md-2 col-form-label">圖片</label>
        <div class="col-md-10">
            <p class="form-control-plaintext">
                <img src="{{ $club->imgurImage->thumbnail('t') }}" alt="Club image">
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
{{ bs()->formGroup(bs()->text('custom_question'))->label('自訂問題')
->helpText('學生填寫回饋資料時，可一併詢問一個問題')->showAsRow() }}
<hr/>
{{ bs()->formGroup(bs()->select('booth_id[]')->attributes(['id' => 'booth_id', 'multiple']))->label('攤位')->showAsRow() }}
{{ bs()->formGroup(bs()->select('leader_nid'))->label('社長')->showAsRow() }}
{{ bs()->formGroup(bs()->select('staff_nid[]')->attributes(['id' => 'staff_nid', 'multiple']))->label('攤位工作人員')->showAsRow() }}

@section('js')
    @parent
    @include('components.tinymce')
    <script>
        $(function () {
            function formatTemplateBooth(booth) {
                if (booth.loading) return booth.text;
                if (!booth.name) return null;

                var markup =  booth.name;
                if(booth.club){
                    markup += ' <span class="badge badge-warning">' + booth.club + '</span>'
                }
                return markup;
            }

            function formatTemplateStudent(student) {
                if (student.loading) return student.text;
                if (!student.name) return null;

                var markup =  '<span class="badge badge-secondary">' + student.id + '</span> ' + student.name;
                if(student.club){
                    markup += ' <span class="badge badge-warning">' + student.club + '</span>'
                }
                return markup;
            }

            function formatTemplateSelection(item) {
                return item.name || item.text;
            }

            var $boothSelect = $('#booth_id');
            var selectedBooth = {!! isset($club) ? $club->booths->pluck('name', 'id')->toJson() : '{}' !!};
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
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
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
            $boothSelect.val(Object.keys(selectedBooth)).trigger('change');

            var studentSelect2Options = {
                tokenSeparators: [',', ' '],
                ajax: {
                    url: '{{ route('api.club-student-list') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
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
                templateResult: formatTemplateStudent, // omitted for brevity, see the source of this page
                templateSelection: formatTemplateSelection // omitted for brevity, see the source of this page
            };
            var selectedLeaders = {!! isset($club) ? $club->leaders->pluck('name', 'nid')->toJson() : '{}' !!};
            var initialLeaders = [];
            $.each(selectedLeaders, function (key, val) {
                initialLeaders.push({id: key, text: val});
            });
            var $leaderSelect = $('#leader_nid');
            $leaderSelect.select2($.extend({}, studentSelect2Options, {
                placeholder: '',
                allowClear: true,
                data: initialLeaders,
            }));
            $leaderSelect.val(Object.keys(selectedLeaders)).trigger('change');

            var selectedStaffs = {!! isset($club) ? $club->staffs->pluck('name', 'nid')->toJson() : '{}' !!};
            var initialStaffs = [];
            $.each(selectedStaffs, function (key, val) {
                initialStaffs.push({id: key, text: val});
            });
            var $staffSelect = $('#staff_nid');
            $staffSelect.select2($.extend({}, studentSelect2Options, {
                tags: true,
                data: initialStaffs,
            }));
            $staffSelect.val(Object.keys(selectedStaffs)).trigger('change');
        });
    </script>
@endsection
