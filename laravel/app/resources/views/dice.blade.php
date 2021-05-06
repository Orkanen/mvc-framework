<p>The message is:</p>

<p>{{ $message }}</p>

<!--<p>{{ json_encode($previousRoll ?? null, TRUE) }}</p>-->
{{ $previousRoll ?? null }}


<form action="{{url('/dice/roll')}}" method="post">
    @csrf
    <input type="hidden" name="title" value=<?php echo $message ?>>
    <input type="submit" value="Roll">
</form>
