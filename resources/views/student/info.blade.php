<dl class="row" style="font-size: 120%">
    <dt class="col-md-2">學號(NID)</dt>
    <dd class="col-md-10">{{ $student->nid }}</dd>

    <dt class="col-md-2">姓名</dt>
    <dd class="col-md-10">{{ $student->name }}</dd>

    <dt class="col-md-2">班級</dt>
    <dd class="col-md-10">{{ $student->class }}</dd>

    <dt class="col-md-2">類型</dt>
    <dd class="col-md-10">{{ $student->type }}</dd>

    <dt class="col-md-2">科系</dt>
    <dd class="col-md-10">
        <span class="badge badge-secondary">{{ $student->unit_id }}</span> {{ $student->unit_name }}
    </dd>

    <dt class="col-md-2">學院</dt>
    <dd class="col-md-10">
        <span class="badge badge-secondary">{{ $student->dept_id }}</span> {{ $student->dept_name }}
    </dd>

    <dt class="col-md-2">入學年度</dt>
    <dd class="col-md-10">{{ $student->in_year }}</dd>

    <dt class="col-md-2">性別</dt>
    <dd class="col-md-10">{{ $student->gender }}</dd>

    <dt class="col-md-2">視為新生</dt>
    <dd class="col-md-10">
        @if($student->consider_as_freshman)
            <i class="fa fa-check fa-2x fa-fw text-success"></i>
        @else
            <i class="fa fa-times fa-2x fa-fw text-danger"></i>
        @endif
    </dd>

    <dt class="col-md-2">新生</dt>
    <dd class="col-md-10">
        @if($student->is_freshman)
            <i class="fa fa-check fa-2x fa-fw text-success"></i>
        @else
            <i class="fa fa-times fa-2x fa-fw text-danger"></i>
        @endif
    </dd>

    <dt class="col-md-2">資料獲取時間</dt>
    <dd class="col-md-10">{{ $student->fetch_at }}</dd>
</dl>
