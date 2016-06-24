<?php
    use App\Achievement;
  use App\User;
?>
<div id='achievement-header' class='clearfix'>
    @if (Auth::user())
        @if ((Auth::user() && Achievement::can_user_submit_proof($main->id))
                && ((Auth::user()->id==$main->user_id && $main->status==0)
                || (Auth::user()->id!=$main->user_id && $main->status!=2) || $main->status==3) )
            @include ('Proof.create', ['achievement_id'=>$main->id])
        @endif
        @include ('Follow.create')
    @endif
</div>
