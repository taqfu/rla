
@if (Auth::user() && Auth::user()->id != $profile->id)
    <h3 class='inline margin-left' style='margin-top:0px;' >
        {{$profile->score}} {{$point_caption}}
    </h3>
   	- Registered {{date('M d, Y', strtotime($profile->created_at))}}
     
    <a  class='margin-left' style='display:block;' href="{{route('new_message', ['id'=>$profile->id])}}">Send Message</a>
@else
    <h3 class='inline margin-left'>{{$profile->score}} {{$point_caption}}</h3>
    <div class='inline'>- Registered {{date('M d, Y', strtotime($profile->created_at))}}</div>
@endif
