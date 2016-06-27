<form method="POST" action="{{route('follow.update', ['id'=>$main->id])}}" class='margin-left margin-top'>
    @foreach ($errors->all() as $error)
    <div class='text-danger'>
        {{$error}}
    </div>
    @endforeach
    <div id='follow-menu' class=' form-group'>
        {{csrf_field()}}
        {{method_field('PUT')}}
        <input type='radio' id='unfollow' class='radio-inline' name='following' value="0"
          @if (!$following)
            checked
          @endif
          />
        <label for='unfollow'>
            @if (!$following)
            <strong>Not Following</strong>
            @else
            Not Following
            @endif
        </label>
        <input type='radio' id='follow' class='radio-inline' name='following' value="1"
          @if ($following)
            checked
          @endif
          />
        <label for='follow'>
            @if ($following)
            <strong>Following</strong>
            @else
            Following
            @endif
        </label>
    </div>
</form>
