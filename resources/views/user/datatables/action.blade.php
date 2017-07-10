<a href="{{ route('user.show', $id) }}" class="btn btn-primary" title="會員資料">
    <i class="fa fa-search" aria-hidden="true"></i>
</a>
<a href="{{ route('user.edit', $id) }}" class="btn btn-primary" title="編輯會員">
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
</a>
{!! Form::open(['route' => ['user.destroy', $id], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除此會員嗎？');"]) !!}
<button type="submit" class="btn btn-danger" title="刪除會員">
    <i class="fa fa-times" aria-hidden="true"></i>
</button>
{!! Form::close() !!}
