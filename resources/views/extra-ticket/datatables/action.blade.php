<a href="{{ route('extra-ticket.edit', $id) }}" class="btn btn-primary" title="編輯">
    <i class="fa fa-edit"></i>
</a>
{!! Form::open(['route' => ['extra-ticket.destroy', $id], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
<button type="submit" class="btn btn-danger" title="刪除">
    <i class="fa fa-times"></i>
</button>
{!! Form::close() !!}
