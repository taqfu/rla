<?php //var_dump($voted_for); ?>
<div style='margin-left:8px;float:left;'>
    <div class='vote_status yes_vote'>
        @if ($voted_for)
            X
        @endif
    </div>
    <div class='vote_status no_vote'>
        @if (!$voted_for)
            X
        @endif
    </div>
</div>
</div>
