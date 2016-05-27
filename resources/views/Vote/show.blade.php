<?php //var_dump($voted_for); ?>
<div class='vote_status'>
    - You voted 

        @if ($voted_for)
        <span class='yes_vote'>for</span>.
        @else
        <span class='no_vote'>against</span>.
        @endif
</div>
