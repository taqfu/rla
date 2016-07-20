
<?php
use \App\Goal;
use \App\User;
if (Auth::guest()){
    $timestamp = date(Config::get('rla.timestamp_format') . ' e', strtotime($goal->created_at));
} else if (Auth::user()){
    $timestamp = date(Config::get('rla.timestamp_format'),
      User::local_time(Auth::user()->timezone, strtotime($goal->created_at)));
}
?>
    <a name='goal{{$goal->id}}'></a>
    <div class='panel panel-default'>
    <div title='{{$timestamp}}' class='achievement-goal panel-body'>
        <div class='goal-timestamp text-center panel-heading'>{{interval($goal->created_at, 'now')}} ago</div>
        <div class='text-center'><a href="{{route('user.show', ['username'=>$goal->user->username])}}">
            {{$goal->user->username}}</a> added this to their bucket list.


        </div>
        <div>
            <a href="{{route('timeline.show', ['id'=>$timeline->id])}}">Permalink</a>
            @if (Goal::can_user_comment($goal->id))
            <button id='show-new-comment{{$goal->id}}' class='show-new-comment btn-link'>[ Comment ]</button>
            @endif

            @if (count($goal->comments)>0)
                <input type='button' id='show-comments{{$goal->id}}' class='show-comments btn-link'
                  value='[ Show Comments ({{count($goal->comments)}}) ]' />
            @endif
            @if (Goal::can_user_comment($goal->id))
                @include ('Comment.create', ['table'=>'goal', 'table_id'=>$goal->id, 'show'=>false])

            @endif
        </div>
        @if (count($goal->comments)>0)
        <div id='comments{{$goal->id}}' class='achievement-goal-comments container hidden'>
            <input type='button' id='hide_comments{{$goal->id}}' class='hide_comments btn-link btn-lg' value='[ - ]' />
            <div id='comments{{$goal->id}}' class=''>
                @foreach ($goal->comments as $comment)
                    @include ('Comment.show', ['comment'=>$comment])
                @endforeach
            </div>
        </div>
        @endif
    </div>
    </div>
