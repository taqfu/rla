<div class='clear'>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        {{$error}}
    @endforeach
@endif
</div>
    <form method="POST" action="{{route('comment.store')}}" id='new_comment{{$table_id}}' class='comment 
@if (!$show)
hidden
@endif
'>

    {{csrf_field()}}
    <input type='hidden' name='replyTo' value='0' />
    <input type='hidden' name='table' value='{{$table}}' />
    <input type='hidden' name='tableID' value='{{$table_id}}'/>
    <div><textarea name='comment' maxlength='21844' class='comment'>{{old('comment')}}</textarea></div>
    
    <input type='submit' value='Comment' class='right' />
    <input type='button' value='Cancel' id='hide_new_comment{{$table_id}}' class='hide_new_comment right'/>
</form>
