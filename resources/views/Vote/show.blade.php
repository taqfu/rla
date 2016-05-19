<?php //var_dump($voted_for); ?>
<div class='vote_status'>
    -
        @if ($voted_for)
        You voted <span class='yes_vote'>in favor</span>.
        @else
        You voted <span class='no_vote'>against</span>.
        @endif
</div>
