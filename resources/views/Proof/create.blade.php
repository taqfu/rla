<form method="POST" action="{{route('proof.store')}}" >
    {{ csrf_field() }}
    <input type='text' name='proofURL' />
    <input type='hidden' name='achievementID' value='{{ $achievement_id }}' /> 
    <input type='submit' value='Prove you did it!' />
</form>
