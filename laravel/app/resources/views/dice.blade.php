<p>The message is:</p>

<p>{{ $message }}</p>



<form action="{{url('/dice/roll')}}" method="post">
    @csrf
    <input type="hidden" name="title" value=<?php echo $message ?>>
    <input type="submit">
</form>
