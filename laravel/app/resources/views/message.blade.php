<?php if(isset($message)) { ?>
  <p>The message is:</p>

  <p>{{ $message }}</p>
<?php } ?>

<?php if(isset($rounds)) { ?>
    <p>Highscore:</p>
    <p>{{ $rounds->score ?? null }}</p>
    <p>{{ $rounds->rounds ?? null }}</p>
<?php } ?>


<a href="./server.php/dice"> Dice | </a>

<a href="./server.php/pizzas"> ORM Pizza | </a>

<a href="./server.php/pizzas/create"> Create Pizza | </a>

<a href="./server.php/dice/score"> Highscore </a>
