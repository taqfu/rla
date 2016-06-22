<?php //var_dump($voted_for); ?>
        @if ($voted_for)
         - <span class='yes-vote'>You voted in favor</span>.
        @else
         - <span class='no-vote'>You voted against</span>.
        @endif
