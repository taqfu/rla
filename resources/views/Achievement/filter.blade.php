<form  method="GET" action="{{route('achievement.index')}}" id='achievement-filters' class='margin-bottom center' >
    &nbsp;
    <div>
        Status:
        <label for='approved' class='approved filter'>Approved
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has been approved and multiple people can submit proof for it at the same time. Voting is only open to those that have already completed the achievement.'>
                (?)
            </span>
        </label>
        <input id='approved' type='checkbox'  name='approved' class='filter' 
          @if($filters['status'][1]=="on")
              checked
          @endif
        />
        
        <label for='denied' class='denied filter'>Denied
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has been denied approval. One person may submit approval at a time and anyone can vote for its approval.'>
                (?)
            </span>
            <input id='denied' type='checkbox' name='denied' class='filter' 
              @if($filters['status'][0]=="on")
                  checked
              @endif
            />
        </label>
        <label for='pending' class='filter pending'>Pending Approval
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement is pending approval. Anyone may vote to determine whether it passes approval.'>
                (?)
            </span>
            <input id='pending' type='checkbox' name='pending' class='filter'
              @if($filters['status'][2]=="on")
                  checked
              @endif
            />
        </label>
        <label for='inactive' class='filter inactive'>Unproven
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has no proofs submitted to it. Submit a proof for approval.'>
                (?)
            </span>
            <input id='inactive' type='checkbox' name='inactive' class='filter'
              @if($filters['status'][3]=="on")
                  checked
              @endif
            />
        </label>
    </div>
    <div class='hidden'>
        Show Only:
        <label for='complete' class='filter complete'>
            Completed  By You
            <span class='filter-tooltip' data-toggle='tooltip' title="You've submitted proof for this achievement and it has been approved!">(?)</span>
            <input id='complete' type='checkbox' name='complete' class='filter'>
        </label>
        <label for='followed' class='filter followed'>
            Followed By You
            <span class='filter-tooltip' data-toggle='tooltip' title="You're following this achievement. All updates will go to your homepage.">(?)</span>
            <input id='followed' type='checkbox' name='followed' class='filter' />
        </label>
    </div>
    @include ("Achievement.sort")
</form>
