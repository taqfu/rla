<div id='achievement_filters' class='hidden margin-bottom center' >
    &nbsp;
@if ($type=='index')
    <div class='clear'>
        Status:
        <label for='approved' class='approved filter'>Approved
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has been approved and multiple people can submit proof for it at the same time. Voting is only open to those that have already completed the achievement.'>
                (?)
            </span>
        </label>
        <input id='approved' type='checkbox'  class='filter' />
        <label for='denied' class='denied filter'>Denied
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has been denied approval. One person may submit approval at a time and anyone can vote for its approval.'>
                (?)
            </span>
            <input id='denied' type='checkbox' class='filter inactive-filter' />
        </label>
        <label for='pending' class='filter pending'>Pending Approval
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement is pending approval. Anyone may vote to determine whether it passes approval.'>
                (?)
            </span>
            <input id='pending' type='checkbox'  class='filter'>
        </label>
        <label for='inactive' class='filter inactive'>Unproven
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has no proofs submitted to it. Submit a proof for approval.'>
                (?)
            </span>
            <input id='inactive' type='checkbox' class='filter inactive-filter'>
        </label>
    </div>
@elseif ($type=='inventory')
    <div class='margin-top'>
        <label for='complete' class='filter complete'>
            Completed  By You
            <span class='filter-tooltip' data-toggle='tooltip' title="You've submitted proof for this achievement and it has been approved!">(?)</span>
            <input id='complete' type='checkbox' class='filter'>
        </label>
        <label for='followed' class='filter followed'>
            Followed By You
            <span class='filter-tooltip' data-toggle='tooltip' title="You're following this achievement. All updates will go to your homepage.">(?)</span>
            <input id='followed' type='checkbox' class='filter' />
        </label>
    </div>

@endif
</div>
