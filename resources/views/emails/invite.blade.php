<div style='text-align:center; font-size:21px;'>
    <p>
        <a href="{{route('user.show', ['username', $username])}}">{{$username}}</a> has invited you to <strong>Do It! Prove It!</strong>
    </p>
    
    <p>
        <strong>Do It! Prove It!</strong> is a community for sharing and tracking accomplishments. Share and track all of the achievements you're proud of in life. Use our bucket list for tracking your goals. Help and be helped with our growing community of achievers. We want to help you achieve everything you want in life!
    </p>
    
    <h3>
        <a href={{route('invite.show', ['email'=>$email])}}">Click here to join <strong>Do It! Prove It!</strong></a>
    </h3>
</div>
<div style='text-align:center;'>
    <a href="{{route('invite.unsubscribe', ['email'=>$email])}}">Unsubscribe</a>
    <a href="{{route('feedback')}}">Feedback</a>
</div>
