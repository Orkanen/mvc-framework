@foreach($pizzas as $pizza)
    <div>
        {{ $pizza->name }}
        {{ $pizza->type }}
        {{ $pizza->base }}
    </div>
@endforeach
