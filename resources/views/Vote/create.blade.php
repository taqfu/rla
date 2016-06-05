<div class='margin-left right'>
    <form method="POST" action="{{route('vote.store')}}" style='float:left;'>
        {{ csrf_field() }}
        <input type='hidden' name='vote_for' value="1" />
        <input type='hidden' name='achievementID' value='{{$proof->achievement_id}}'/>
        <input type='hidden' name='proofID' value='{{$proof->id}}'/>
        <input type='submit' value='Yes' />
    </form>
    <form method="POST" action="{{route('vote.store')}}" style='float:left;'>
        {{ csrf_field() }}
        <input type='hidden' name='vote_for' value="0" />
        <input type='hidden' name='achievementID' value='{{$proof->achievement_id}}'/>
        <input type='hidden' name='proofID' value='{{$proof->id}}'/>
        <input type='submit' value='No' />
    </form>
</div>
