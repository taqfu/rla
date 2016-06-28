<div class='container margin-top'>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div>{{$error}}</div>
    @endforeach
@endif
    <form method="POST" role='form' action="{{route('comment.store')}}" id='new_comment{{$table_id}}' class='margin-left comment
      @if (!$show)
      hidden
      @endif
      '>
        {{csrf_field()}}
        <input type='hidden' name='replyTo' value='0' />
        <input type='hidden' name='table' value='{{$table}}' />
        <input type='hidden' name='tableID' value='{{$table_id}}'/>
        <div class='form-group'>
            <textarea name='comment' maxlength='21844' class='form-control'>{{old('comment')}}</textarea>
        </div>
        <div class='form-group'>
            <input type='submit' value='Comment' class='right' />
            <input type='button' value='Cancel' id='hide_new_comment{{$table_id}}' class='hide_new_comment right'/>
        </div>
    </form>
</div>
