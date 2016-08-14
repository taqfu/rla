<form method="POST" action="{{route('claim.store')}}" role='form' class='margin-left'>
{{csrf_field()}}
<input type='hidden' name='achievementID' value='{{$main->id}}' />
No Proof? <button type='submit' class='btn-link'>Claim.</button>
</form>
