<?php 
//$default_achievement_val = old('name')==NULL ? "Create or search here." : old('name')
$default_achievement_val = "Create or search here.";    
?>
<div class='text-center container margin-top'>
    <div class=' text-danger'>
        @foreach ($errors->all() as $error)
        <div>
            {{$error}}
        </div>
        @endforeach
    </div>
    <input type='text' id='create-achievement' class='input-lg text-muted form-control'
      name='name' value="{{$default_achievement_val}}" maxlength='100' autocomplete="off" />
    <div id='achievement-results'></div>
</div>
