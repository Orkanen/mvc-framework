<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

use function Fian\Functions\url;

$header = $header ?? null;
$message = $message ?? null;
$hold = $hold ?? null;
//$url = "/yatzy/firstRoll";
$url = "test"
?><h1><?= $header ?></h1>

<p><?= $message ?></p>
<p>{{ $message }}</p>
<?= $rollDice = $rollDice ?? null; ?>

<form action="<?= $url; ?>" method="post">

    <fieldset>
        <legend>Game of Dice</legend>
        <?= $dice = $dice ?? null; ?>
        <p><label><br>

            <?= $form = $form ?? null; ?>
        </label></p>

    </fieldset>

</form>

<form action="<?= $url; ?>" method="post">
    <p><?= $hold ?></p>
</form>
