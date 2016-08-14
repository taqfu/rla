
@extends ('layouts.app')
@section('title')
 - A Community for Sharing and Tracking Accomplishments
@endsection
@section ('content')
<div id='public-page'>
    <h3 id='public-message' class='page-header text-center'>
        <div class='container margin-top-4'>
            <img src="{{url('/')}}/img/logo1-trimmed.png" class='image-responsive'>
        </div>
        <div class='container-flexible margin-top-4'>
                <i>Do It! Prove It!</i> is an up-and-coming community for tracking and sharing your accomplishments. If you've ever wished real life achievements were a thing or wanted to create a bucket list, this is the site for you.
        </div>
        <div class='container margin-top-2 margin-bottom-4'>
            <a href="{{route('achievement.index', Config::get('rla.default_filter') )}}">
                Check out the achievements available!
            </a>
        </div>
    </h3>
<div class='margin-top-4 margin-bottom-4'>
        <h1 class='text-center'>How It Works</h1>
        <ul>
            <li><h2> Do It!</h2></li>
            <h4>Every thing you do is an achievement. If you don't see the achievement listed, feel free to make it. Each achievement's score is based off people voting it up or down.
            </h4>
            <li><h2> Prove It!</h2></li>
            <h4>
            Copy and paste the URL to any proof that you completed the achievement and submit it. Everyone who previously completed the achievement will vote on its approval. If no one has completed it yet, everyone can vote. Once you complete the achievement, you receive the achievement's current score. (This includes negative scores.)
            </h4>
        <h2 class='container text-center margin-top-4 margin-bottom-4'>
            <a href="{{route('achievement.index', Config::get('rla.default_filter') )}}">
                Check out the achievements available!
            </a>
        </h2>
</div>
@endsection
