<a href="{{ route('student.show', $id) }}" class="btn btn-primary" title="檢視">
    <i class="fa fa-search" aria-hidden="true"></i>
</a>
<a href="{{ route('student.edit', $id) }}" class="btn btn-primary" title="編輯">
    <i class="fa fa-edit" aria-hidden="true"></i>
</a>

{!! Form::open(['route' => ['student.fetch', $id], 'style' => 'display: inline', 'method' => 'PUT']) !!}
<button type="submit" class="btn btn-primary" title="更新學生">
    <i class="fa fa-sync" aria-hidden="true"></i>
</button>
{!! Form::close() !!}
