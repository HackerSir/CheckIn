<a href="{{ route('club-type.edit', $id) }}" class="btn btn-primary" title="編輯社團類型">
    <i class="fa fa-edit"></i>
</a>
{!! Form::open(['route' => ['club-type.destroy', $id], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
<button type="submit" class="btn btn-danger" title="刪除社團類型">
    <i class="fa fa-times"></i>
</button>
{!! Form::close() !!}
