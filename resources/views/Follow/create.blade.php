<form method="POST" action="{{route('follow.update', ['id'=>$main->id])}}" role='form' class='inline pull-left' >
    @foreach ($errors->all() as $error)
    <div class='text-danger'>
        {{$error}}
    </div>
    @endforeach
    <div id='follow-menu' class=' form-group'>
    
        {{csrf_field()}}
        {{method_field('PUT')}}
        @if ($following)
        <input type='hidden' name='following' value="0" />
        <button type='submit' class='btn-danger'>Unsubscribe</button>
        @else
        <input type='hidden' name='following' value="1" />
        <button type='submit' class='btn-success'>Subscribe</button>
        @endif
    </div>
</form>
