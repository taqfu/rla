<div style='clear:both;'>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        {{$error}}
    @endforeach
@endif
</div>
<form id='new_comment{{$table_id}}' method="POST" action="{{route('comment.store')}}" style='clear:both;
@if (!$show)
display:none;
@endif
' class='comment'>
    {{csrf_field()}}
    <input type='hidden' name='replyTo' value='0' />
    <input type='hidden' name='table' value='{{$table}}' />
    <input type='hidden' name='tableID' value='{{$table_id}}'/>
    <div><textarea name='comment' maxlength='21844' class='comment'>{{old('comment')}}</textarea></div>
    
    <input type='submit' value='Comment' style='float:right;'/>
    <input type='button' value='Cancel' style='float:right;' id='hide_new_comment{{$table_id}}' class='hide_new_comment'/>
</form>
