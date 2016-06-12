@extends ('layouts.app')

@section('content')
<p>
    <i>This is where you'll be able to see the changes I've made.</i> <a href="{{route('feedback')}}">Head here for any feedback.</a>
</p>
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
