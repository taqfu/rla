<div class='well margin-top text-center'>
    <h4><strong>
        @if (substr($story->user->username, -1)=='s')
            {{$story->user->username}}'
        @else
            {{$story->user->username}}'s
        @endif
        story
    </strong></h4>
    <div class='text-center'>
        {{$story->story}} 
    </div>
</div>
