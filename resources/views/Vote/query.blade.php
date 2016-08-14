<?php
    use \App\Vote; 
    use \App\Proof;
?>
@if (Auth::user())
    <?php $vote = Vote::where('proof_id', $proof->id)->where('user_id', Auth::user()->id)->first(); ?>
    @if ($vote==null && $proof->status==2 && Proof::can_user_vote($proof->id))
        @include ('Vote.create')
    @elseif ($vote!=null && !$create_only)
        @include ('Vote.show', ['voted_for'=>$vote->vote_for])
    @else 
        @if ($proof->status==2)
        <div><strong>
            Because you have not completed this achievement, you are unable to vote.
        </strong></div>
        @endif
    @endif
    
@endif
