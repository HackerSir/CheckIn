<a href="{{ route('booth.show', $id) }}" class="btn btn-primary" title="攤位資料">
    <i class="fa fa-search"></i>
</a>
<a href="{{ route('booth.edit', $id) }}" class="btn btn-primary" title="編輯攤位">
    <i class="fa fa-edit"></i>
</a>
{!! Form::open(['route' => ['booth.destroy', $id], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
<button type="submit" class="btn btn-danger" title="刪除攤位">
    <i class="fa fa-times"></i>
</button>
{!! Form::close() !!}
