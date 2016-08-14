<form method="POST" action="{{route('proof.destroy', ['id'=>$proof->id])}}" class='inline margin-left'>
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <input type='submit' value='[ Cancel ]' class='btn-link' />
</form>
