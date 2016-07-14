<form method="POST" 
  action="{{route('goal.destroy', ['id'=>$goal->id])}}" role='form' class='inline' />
    {{csrf_field()}}
    {{method_field('delete')}}
    <button type='submit' class='btn-danger'>-
    @if ($extra)
    Bucket List
    @endif
    </button>
</form>
