@extends('layouts.base')

@section('title', '新增聯絡資料')

@section('buttons')
    <a href="{{ route('contact-information.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>聯絡資料
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('contact-information.store')) }}
            {{ bs()->formGroup(bs()->select('student_nid'))->label('學生')->showAsRow() }}
            @include('contact-information.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script>
        $(function () {
            function formatTemplateStudent(student) {
                if (student.loading) return student.text;
                if (!student.name) return null;

                var markup =  '<span class="badge badge-secondary">' + student.id + '</span> ' + student.name;
                return markup;
            }

            function formatTemplateSelection(item) {
                return item.name || item.text;
            }

            var studentSelect2Options = {
                tokenSeparators: [',', ' '],
                ajax: {
                    url: '{{ route('api.student-list') }}',
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
                            page: params.page
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
            var $studentSelect = $('#student_nid');
            $studentSelect.select2(studentSelect2Options);
        });
    </script>
@endsection
