<?php
    use App\Achievement;
  use App\User;
?>
<div id='achievement-header' class='clearfix'>
    @if (Auth::user())
        @if ($user_proof!=NULL)
        <div class='margin-left lead'>
            You first completed this achievement 
            {{date(Config::get('rla.date_format'), strtotime($user_proof->created_at))}}.   
        </div>
        @elseif (Achievement::can_user_submit_proof($main->id) 
          && ($main->status!=2))
            @include ('Proof.create', ['achievement_id'=>$main->id])
            <!--{{var_dump(Achievement::can_user_claim($main->id))}}-->
            @if (Achievement::can_user_claim($main->id))           
            <form method="POST" action="{{route('claim.store')}}" role='form' class='margin-left'>
            {{csrf_field()}}
            <input type='hidden' name='achievementID' value='{{$main->id}}' />
            No Proof? <button type='submit' class='btn-link'>Claim.</button>
            </form>
            @endif
        @endif
        @if ($user_claim!=null)
        <form method="POST" action="{{route('claim.destroy', ['id'=>$user_claim->id])}}" 
          role='form' class='margin-left lead'>
            {{csrf_field()}}
            {{method_field('DELETE')}}
            You claimed to have completed this achievement on 
            {{date(Config::get('rla.date_format'), strtotime($user_claim->created_at))}}. 
            <button type='submit' class='btn-link'>Withdraw Claim</button>
        </form>

        @endif
    @endif
    <div class='margin-left' title="
      @if (Auth::guest())
      {{date(Config::get('rla.timestamp_format') . ' e', strtotime($main->created_at))}}
      @elseif (Auth::user())
      {{ date(Config::get('rla.timestamp_format'), User::local_time(Auth::user()->timezone, strtotime($main->created_at)))}}
      @endif
      "><strong>
        Created by <a href="{{route('user.show', ['id'=>$main->user_id])}}">{{$main->user->username}}</a>
        {{interval($main->created_at, 'now')}} ago 
    </strong></div>
    <div class='margin-left'>
        @if ($main->status==0)
        <span class='fail'><strong>
            Denied
        </strong></span>
        <i>
         - don't let this discourage you! submit a new proof! anyone can vote
        </i>
        @elseif ($main->status==1)
        <span class='pass'><strong>
            Approved
        </strong></span>
        <i>
             - only those that have already completed the achievement can vote 
        </i>
        @elseif ($main->status==2)
        <strong>
            Pending Approval
        </strong>
        <i>
             - anyone can vote
        </i>
        @elseif ($main->status==3)
        <strong>
            Inactive
        </strong>
        <i>
             - be the first one to submit proof!
        </i>
        @elseif ($main->status==4)
        <span class='fail'><strong>
            Canceled
        </strong></span>
        <i>
             - proof was canceled. submit your proof today!
        </i>
        @endif 
    </div>
    <div class='margin-left'>
        <strong>
            {{count($main->proofs)}} proofs submitted. 
                @if (count($main->proofs)>0)
                <i>
                    ({{round(((count($main->proofs) -
                      count($main->denied_proofs))/count($main->proofs)), 2)*100}}% Approval)
                </i>
                @endif
        </strong>
    </div>
</div>
