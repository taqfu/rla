<form method="POST" action="{{route('claim.destroy', ['id'=>$user_claim->id])}}" 
  role='form' class='margin-left lead'>
    {{csrf_field()}}
    {{method_field('DELETE')}}
    You claimed to have completed this achievement on 
    {{date(Config::get('rla.date_format'), strtotime($user_claim->created_at))}}. 
    <button type='submit' class='btn-link'>Withdraw Claim</button>
</form>
