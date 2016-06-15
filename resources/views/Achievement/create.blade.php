<div class='center fail'>
    @foreach ($errors->all() as $error)
    <div>
        {{$error}}
    </div>
    @endforeach
</div>
<div class='center'>
    <input id='create_achievement' type='text'  name='name' value="{{old('name')==NULL ? "Create or search here." : old('name')}}" maxlength='100' />
</div>
<div class='center hidden'>
    <form method="POST" action="{{ route('achievement.store') }}" class='achievement'>
        {{ csrf_field() }}
        <div>
            <label>Achievement Name:</label>
            <input type='text' name='name' value="{{old('name')}}" maxlength='100'/> 
        </div>
        <div>
            <label>URL Of Proof(optional):</label>
            <input type='url' name='proofURL' value="{{old('proofURL')}}" maxlength='256'/>
        </div>
        <div>
            <input type='submit' value='Create Achievement'>
        </div>
    </form>
</div>
