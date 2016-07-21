<form class='text-center' method="POST" action="{{route('timeline.filters')}}" role='form'>
    {{csrf_field()}}
    {{method_field('put')}}
    <div>
        <label class='filter'>
            <input type='checkbox' name='newProof' class='checkbox-inline'
            @if (session('timeline_filters')['new_proof'])
            checked
            @endif
            />
            New Proof
        </label>
        <label class='filter'>
            <input type='checkbox' name='changeProofStatus' class='checkbox-inline'
            @if (session('timeline_filters')['change_proof_status'])
            checked
            @endif
            />
            Change Proof Status
        </label>
        <label class='filter'>
            <input type='checkbox' name='cancelProof' class='checkbox-inline'
            @if (session('timeline_filters')['cancel_proof'])
            checked
            @endif
            />
            Cancel Proof
        </label>
        <label class='filter'>
            <input type='checkbox' name='swingVote' class='checkbox-inline'
            @if (session('timeline_filters')['swing_vote'])
            checked
            @endif
            />
            Swing Votes
        </label>
    </div>
    <div>
        <label class='filter'>
            <input type='checkbox' name='newAchievement' class='checkbox-inline'
            @if (session('timeline_filters')['new_achievement'])
            checked
            @endif
            />
            New Achievements
        </label>
        <label class='filter'>
            <input type='checkbox' name='changeAchievementStatus' class='checkbox-inline'
            @if (session('timeline_filters')['change_achievement_status'])
            checked
            @endif
            />
            Change Achievement Status
        </label>
    </div>
    <div>
        <label class='filter'>
            <input type='checkbox' name='newGoal' class='checkbox-inline'
            @if (session('timeline_filters')['new_goal'])
            checked
            @endif
            />
            New Goals
        </label>
        <label class='filter'>
            <input type='checkbox' name='newClaim' class='checkbox-inline'
            @if (session('timeline_filters')['new_claim'])
            checked
            @endif
            />
            New Claim
        </label>
        <label class='filter'>
            <input type='checkbox' name='newComment' class='checkbox-inline'
            @if (session('timeline_filters')['new_comment'])
            checked
            @endif
            />
            New Comment
        </label>
    </div>
    <button type='submit'>Filter</button>
</form>
