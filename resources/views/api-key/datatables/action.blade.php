{!! Form::open(['route' => ['api-key.destroy', $id], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
<button type="submit" class="btn btn-danger" title="刪除ApiKey">
    <i class="fa fa-times" aria-hidden="true"></i>
</button>
{!! Form::close() !!}
