<form method="POST" 
  action="{{route('goal.destroy', ['id'=>$goal->id])}}" role='form' class='inline' />
    {{csrf_field()}}
    {{method_field('delete')}}
    <input type='hidden' name='achievementID' value='{{$goal->id}}' />
    <button type='submit' class='btn-danger'>-
    @if ($extra)
    Bucket List
    @endif
    </button>
</form>
