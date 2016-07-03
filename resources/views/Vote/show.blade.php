<?php //var_dump($voted_for); ?>

        @if ($voted_for)
        <div class='pass'>You voted in favor</div>.
        @else
        <div class='fail'>You voted against</div>.
        @endif
