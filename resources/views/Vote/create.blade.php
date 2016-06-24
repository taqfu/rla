<div class='margin-top'>
    <strong>
    Is this proof?
    </strong>
</div>
<div class='text-center'>
<form method="POST" action="{{route('vote.store')}}" class='inline' role='form'>
    {{ csrf_field() }}
    <input type='hidden' name='vote_for' value="1" />
    <input type='hidden' name='achievementID' value='{{$proof->achievement_id}}'/>
    <input type='hidden' name='proofID' value='{{$proof->id}}'/>
    <input type='submit' value='[ Yes ]' class='btn-link btn-lg'/>
</form>
<form method="POST" action="{{route('vote.store')}}" class='inline' role='form'>
    {{ csrf_field() }}
    <input type='hidden' name='vote_for' value="0" />
    <input type='hidden' name='achievementID' value='{{$proof->achievement_id}}'/>
    <input type='hidden' name='proofID' value='{{$proof->id}}'/>
    <input type='submit' value='[ No ]' class='btn-link btn-lg'/>
</form>
</div>
