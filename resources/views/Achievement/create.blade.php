<?php 
//$default_achievement_val = old('name')==NULL ? "Create or search here." : old('name')
$default_achievement_val = "Create or search here.";    
?>
<div class='text-center text-danger'>
    @foreach ($errors->all() as $error)
    <div>
        {{$error}}
    </div>
    @endforeach
</div>
<div class='text-center'>
    <input type='text' id='create-achievement' class='text-muted'
      name='name' value="{{$default_achievement_val}}" maxlength='100' autocomplete="off" />
    <div id='achievement-results'></div>
</div>
