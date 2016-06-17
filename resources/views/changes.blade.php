@extends ('layouts.app')

@section('content')
<p>
    <i>This is where you'll be able to see the changes I've made.</i> 
    <a href="{{route('feedback')}}">Head here for any feedback.</a>
</p>
<h4>06/17/16</h4>
<ul>
    <li>Creating achievements has now been integrated into a single search/create text bar.</li>
    <li>Going to a profile page for an achievement that has been deleted will now not cause an error. (Achievements that are deleted are mainly test achievements. We are not trying to avoid censorship.</li>
</ul>
<h4>06/15/16</h4>
<ul>
    <li>Comments now visible in user's profile.</li>
</ul>
<h4>06/14/16</h4>
<ul>
    <li>Inventory achievements can also be sorted.</li>
</ul>
<h4>06/13/16</h4>
<ul>
    <li>User profiles have been extended to include completed achievements, followed achievements and when user signed up.</li>
    <li>
        <del>Achievement unlocked CSS icon removed from public front page due to compatiblity issue with lower resolutions.</del>
        <ins>Resolved. (Still not on mobile.)</ins>
    </li>
    <li>Achievement listings can now be sorted.</li>
</ul>
<h4>06/12/16</h4>
<ul>
    <li>Inventory created. Users can manage now achievements that they are following or completed.</li>
</ul>
<h4>06/11/16</h4>
<ul>
    <li>Fixed a bug with submitting proof to already created achievements. Proof was submitting but the follows, votes and timeline were not being implemented.</li>
    <li>Fixed footer not displaying properly in mobile.</li>
    <li>When user's points are updated, this information will be added to their timelines.</li>
    <li>Proof submission can be cancelled if it is still pending approval.</li>
</ul>
<h4>06/10/16</h4>
<ul>
    <li>Hopefully made the filters a little clearer by changing the caption names and also adding a (?) tooltip to it.</li>
    <li>Achievement score now visible to guests. Achievements listed by score in descending order.</li>
    <li>Achievement score is now added to user's score on completion. (This means negative scores will be deducted from your score.)</li>
    <li>When someone completes your achievement, you receive a point.</li>
</ul>
<h4>06/09/16</h4>
<ul>
    <li>Added voting to achievements. Thanks <a href="https://www.reddit.com/user/bobyd">/u/bobyd</a>!</li>
    <li>Inactive and denied achievements are now not visible by default.</li>
    <li>Achievement filter menu on achievement listings page is hopefully a little clearer now.</li>
</ul>
@endsection
