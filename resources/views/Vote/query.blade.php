<?php
    use \App\Vote; 
?>
@if (Auth::user())
    <?php $vote = Vote::where('proof_id', $proof->id)->where('user_id', Auth::user()->id)->first(); ?>
    @if ($vote==null && $proof->status==2)
        @include ('Vote.create')
    @elseif ($vote!=null && !$create_only)
        @include ('Vote.show', ['voted_for'=>$vote->vote_for])
    @endif
@endif
