<?php //var_dump($voted_for); ?>
<div class='vote_status margin-left'>
        @if ($voted_for)
        <span class='yes_vote'>You voted in favor</span>.
        @else
        <span class='no_vote'>You voted against</span>.
        @endif
</div>
