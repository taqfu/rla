
<form class='create_proof' method="POST" action="{{route('proof.store')}}" >
    {{ csrf_field() }}
    <?php $proof_url_val = (old('proofURL')==null) ? "Paste URL here." : old('proofURL'); ?>
    <input id='create-proof-url' type='text' name='proofURL' value="{{$proof_url_val}}"/>
    <input type='hidden' name='achievementID' value='{{ $achievement_id }}' /> 
    <input type='submit' value='Prove you did it!' />
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        {{$error}}
        @endforeach
    @endif
</form>
