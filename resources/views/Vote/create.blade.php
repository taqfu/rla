<div id='vote-on-proof{{$proof->id}}' class='text-center margin-top'>
    <strong>
        Is this proof?
    </strong>
    <input id='proof-vote-achievement-id{{$proof->id}}' type='hidden' 
      value='{{$proof->achievement_id}}' />
    <button id='proof-yes-vote{{$proof->id}}' class='proof-yes-vote btn-link btn-lg'>Yes</button>
    <button id='proof-no-vote{{$proof->id}}' class='proof-no-vote btn-link btn-lg'>No</button>
</div>
