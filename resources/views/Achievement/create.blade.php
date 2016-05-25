    @foreach ($errors->all() as $error)
        {{$error}}
    @endforeach
<form method="POST" action="{{ route('achievement.store') }}" style='margin-bottom:32px;text-align:center;'>
    {{ csrf_field() }}
        <label>
            Achievement Name: 
        </label>
        <input type='text' name='name' value="{{old('name')}}" maxlength='140'/> 
    <label style='margin-left:16px;'>
        URL Of Proof:
    </label>
    <input type='url' name='proofURL' value="{{old('proofURL')}}" maxlength='256'/>
    <input type='submit' value='Submit Approval' style='margin-left:16px;'> 
</form>
