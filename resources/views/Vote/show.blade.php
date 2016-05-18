<?php //var_dump($voted_for); ?>
<div style='margin-left:8px;float:left;'>
    <div style='background-color:green;width:20px;height:20px;float:left;text-align:center;font-weight:bold;color:white;'>
        @if ($voted_for)
            X
        @endif
    </div>
    <div style='background-color:red;width:20px;height:20px;float:left;text-align:center;font-weight:bold;color:white;'>
        @if (!$voted_for)
            X
        @endif
    </div>
</div>
</div>
