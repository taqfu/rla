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
        @endif
        @if (Achievement::can_user_submit_proof($main->id)
          && ($main->status!=2))
            @include ('Proof.create', ['achievement_id'=>$main->id])
            <!--{{var_dump(Achievement::can_user_claim($main->id))}}-->
            @if (Achievement::can_user_claim($main->id)
              && !Achievement::has_user_completed_achievement($main->id))
                @include ('Claim.create')
            @endif
        @endif
        @if ($user_claim!=null)
            @include ('Claim.destroy')

        @endif
    @else
    <div class='container margin-top-2 text-center lead'><strong>
        <a href="{{url('/login')}}">Log in</a> or <a href="{{url('/register')}}">register</a> to complete this achievement.
    </strong></div>
    @endif
    <div class='margin-left' title="
      @if (Auth::guest())
      {{date(Config::get('rla.timestamp_format') . ' e', strtotime($main->created_at))}}
      @elseif (Auth::user())
      {{ date(Config::get('rla.timestamp_format'), User::local_time(Auth::user()->timezone, strtotime($main->created_at)))}}
      @endif
      "><strong>
        Created by <a href="{{route('user.show', ['username'=>$main->user->username])}}">{{$main->user->username}}</a>
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
        {{Achievement::fetch_num_of_users_who_completed($main->id)}} people have completed this achievement.
        <strong>
                @if (count($main->approved_proofs)>0)
                <i>
                    ({{round(count($main->approved_proofs)/((count($main->approved_proofs) +
                      count($main->denied_proofs))), 2)*100}}% Approval)
                </i>
                @endif
        </strong>
    </div>
    @include('share', ['url'=>route('achievement.show', ['url'=>$main->url])])
</div>
