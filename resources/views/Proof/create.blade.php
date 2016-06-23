
<form class='create_proof' method="POST" action="{{route('proof.store')}}" role='form' >
    <div class='form-group'>
    {{ csrf_field() }}
    <?php $proof_url_val = (old('proofURL')==null) ? "Paste URL here." : old('proofURL'); ?>
    <input id='create-proof-url' type='text' name='proofURL' value="{{$proof_url_val}}" class='form-control'/>
    <input type='hidden' name='achievementID' value='{{ $achievement_id }}' /> 
    <input type='submit' value='Prove you did it!' />
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class='text-danger'>
        {{$error}}
        </div>
        @endforeach
    @endif
    </div>
</form>
