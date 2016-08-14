<form  method="POST" action="{{route('achievement.filters')}}" id='achievement-filters' 
  class='text-center form-inline
  @if (count($achievements)==0)
  page-header
  @endif
  ' role='form' >
    {{csrf_field()}}
    {{method_field('put')}}
    <div class='container-flexible form-group'>
        Status:
        <label for='approved' class='approved filter '>Approved
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has been approved and multiple people can submit proof for it at the same time. Voting is only open to those that have already completed the achievement.'>
                (?)
            </span>
            <input id='approved' type='checkbox'  name='approved' class='status-filter checkbox-inline' 
              @if(session('achievement_filters')['status']['approved'])
                  checked
              @endif
            />
        </label>
        
        <label for='denied' class='denied filter '>Denied
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has been denied approval. One person may submit approval at a time and anyone can vote for its approval.'>
                (?)
            </span>
            <input id='denied' type='checkbox' name='denied' class='status-filter checkbox-inline' 
              @if(session('achievement_filters')['status']['denied'])
                  checked
              @endif
            />
        </label>
        <label for='pending' class='filter pending'>Pending Approval
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement is pending approval. Anyone may vote to determine whether it passes approval.'>
                (?)
            </span>
            <input id='pending' type='checkbox' name='pending' class='status-filter checkbox-inline'
              @if(session('achievement_filters')['status']['pending'])
                  checked
              @endif
            />
        </label>
        <label for='inactive' class='filter inactive'>Unproven
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has no proofs submitted to it. Submit a proof for approval.'>
                (?)
            </span>
            <input id='inactive' type='checkbox' name='inactive' class='status-filter checkbox-inline'
              @if(session('achievement_filters')['status']['inactive'])
                  checked
              @endif
            />
        </label>
        <label for='canceled' class='filter canceled'>Cancelled
            <span class='filter-tooltip' data-toggle='tooltip'
              title='The proof for this achievement was canceled. Submit another one! Anyone can vote.'>
                (?)
            </span>
            <input id='canceled' type='checkbox' name='canceled' class='status-filter checkbox-inline'
              @if(session('achievement_filters')['status']['canceled'])
                  checked
              @endif
            />
        </label>
        <label for='all-filters' class='filter'>All
            <input id='all-filters' type='checkbox' class='checkbox-inline'
            @if (session('achievement_filters')['status']['approved'] && session('achievement_filters')['status']['denied'] && 
              session('achievement_filters')['status']['pending'] && session('achievement_filters')['status']['inactive'] 
              && session('achievement_filters')['status']['canceled'])
            checked
            @endif
            />
        </label>
        <button type='submit' class='btn btn-default'>
            Filter
        </button>
    </div>
    @if (Auth::user())
    <div class=''>
        Completion:
        <label for='incomplete' class='filter incomplete'>
            Incomplete
            <span class='filter-tooltip' data-toggle='tooltip' title="You have not completed this achievement.">(?)</span>
            <input id='incomplete' type='checkbox' name='incomplete' class='filter checkbox-inline'
            @if (session('achievement_filters')['incomplete'])
            checked
            @endif
            />
        </label>
        <label for='complete' class='filter complete'>
            Completed
            <span class='filter-tooltip' data-toggle='tooltip' title="You've submitted proof for this achievement and it has been approved!">(?)</span>
            <input id='complete' type='checkbox' name='complete' class='filter checkbox-inline'
            @if (session('achievement_filters')['complete'])
            checked
            @endif
            />
        </label>
        <label for='claimed' class='filter claimed'>
            Claimed
            <span class='filter-tooltip' data-toggle='tooltip' title='You have no proof but you claim to have completed the achievement.'>(?)</span>
            <input id='claimed' type='checkbox' name='claimed' class='filter checkbox-inline'
            @if (session('achievement_filters')['claimed'])
            checked
            @endif
            />
        </label>
        <label for='followed' class='filter followed'>
            Followed
            <span class='filter-tooltip' data-toggle='tooltip' title="You're following this achievement. All updates will go to your homepage.">(?)</span>
            <input id='followed' type='checkbox' name='followed' class='filter checkbox-inline' 
            @if (session('achievement_filters')['followed'])
            checked
            @endif
            />
        </label>
    </div>
    @endif
</form>
