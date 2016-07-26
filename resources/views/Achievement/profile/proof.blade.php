
<?php
    use \App\Achievement;
    use \App\Proof;
    use \App\User;
    $story = Proof::fetch_story($proof->id);
?>
    <?php
    if (Auth::guest()){
        $timestamp = date(Config::get('rla.timestamp_format') . ' e', strtotime($proof->created_at));
    } else if (Auth::user()){
        $timestamp = date(Config::get('rla.timestamp_format'),
          User::local_time(Auth::user()->timezone, strtotime($proof->created_at)));
    }
    ?>
    <a name='proof{{$proof->id}}'></a>
    <div class='panel panel-default'>
    <div title='{{$timestamp}}' class='achievement-proof panel-body'>
        <div class='proof-timestamp text-center panel-heading'>{{interval($proof->created_at, 'now')}} ago</div>
        <div class='text-center'><a href="{{route('user.show', ['username'=>$proof->user->username])}}">{{$proof->user->username}}</a>
            submitted <a href="{{route('proof.show', ['id'=>$proof->id])}}">proof</a> of completion.
            (<a target='_blank' href="{{$proof->url}}">{{$proof->url}}</a>)
        </div>
        <div class='text-center'>
            @if ($proof->status==0)
            <span class='fail'>Denied (
                @if (Auth::guest())
                {{date(Config::get('rla.date_format'), strtotime($proof->updated_at))}}
                @elseif (Auth::user())
                {{date(Config::get('rla.date_format'), User::local_time(Auth::user()->timezone, strtotime($proof->updated_at)))}}
                @endif
            )</span>

            @elseif ($proof->status==1)
            <span class='pass'>Approved (
              @if (Auth::guest())
              {{date(Config::get('rla.date_format'), strtotime($proof->updated_at))}}
              @elseif (Auth::user())
              {{date(Config::get('rla.date_format'), User::local_time(Auth::user()->timezone, strtotime($proof->updated_at)))}}
              @endif

              )</span>
            @elseif ($proof->status==2)
            <i>
                Pending Approval - {!!Proof::min_time_to_vote($proof->id)!!} left to vote. {{Proof::max_time_to_vote($proof->id)}} max.
                <?php $is_it_passing = Proof::passing_approval($proof->id); ?>
                @if ($is_it_passing)
                    (<span class='pass'>Passing</span>)
                @else
                    (<span class='fail'>Failing</span>)
                @endif
            </i>
                @if (Auth::user() && $proof->user_id == Auth::user()->id)
                    @include ('Proof.destroy')
                @endif
            @elseif ($proof->status==4)
            <i>
                Canceled
              @if (Auth::guest())
              {{date(Config::get('rla.date_format'), strtotime($proof->updated_at))}}
              @elseif (Auth::user())
              {{date(Config::get('rla.date_format'), User::local_time(Auth::user()->timezone, strtotime($proof->updated_at)))}}
              @endif
            </i>
            @endif
            @if (Auth::user() && $proof->user_id != Auth::user()->id)
                @include ('Vote.query', ['create_only'=>false])
            @endif
        </div>
        @if ($story!=null)
            @include ('Story.show', ['story'=>$story])
        @endif
        <div>
            <a href="{{route('timeline.show', ['id'=>$timeline->id])}}">Permalink</a>

            @if ( Proof::can_user_comment($proof->id))
            <button id='show-new-comment{{$proof->id}}' class='show-new-comment btn-link'>
                Comment
            </button>
            @endif


            @if (count($proof->comments)>0)
                <input type='button' id='show-comments{{$proof->id}}' class='show-comments btn-link'
                  value=' Show Comments ({{count($proof->comments)}}) ' />
            @endif
            @if (Auth::user() && Auth::user()->id == $proof->user_id)
                @if($story==null)
                    <button id='show-new-proof-story{{$proof->id}}' class='btn-link show-new-story'>
                        Add Story
                    </button>
                    @include ('Story.create', ['hidden'=>true, 'table_name'=>'proof', 
                      'id_num'=>$proof->id])
                @else
                    <button id='show-edit-story{{$story->id}}' class='btn-link show-edit-story'>
                        Edit Story
                    </button>
                    @include ('Story.edit', ['hidden'=>true, 'story'=>$story])
                @endif
            @endif
            @if (Proof::can_user_comment($proof->id))
                @include ('Comment.create', ['table'=>'proof', 'table_id'=>$proof->id, 'show'=>false])

            @endif
        </div>
        @if (count($proof->comments)>0)
        <div id='comments{{$proof->id}}' class='achievement-proof-comments container hidden'>
            <input type='button' id='hide_comments{{$proof->id}}' class='hide_comments btn-link btn-lg' value='-' />
            <div id='comments{{$proof->id}}' class=''>
                @foreach ($proof->comments as $comment)
                    @include ('Comment.show', ['comment'=>$comment])
                @endforeach
            </div>
        </div>
        @endif
    </div>
    </div>
