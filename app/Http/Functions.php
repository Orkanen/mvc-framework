<?php

//namespace App\Http;
namespace Fian\Http\Functions;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Fian\Dice\Dice;
use Fian\Dice\DiceHand;
use Fian\Dice\DiceGraphic;
use Fian\Dice\Rounds;

/**
 * Functions.
 */


/**
 * Get the route path representing the page being requested.
 *
 * @return string with the route path requested.
 */
function getRoutePath(): string
{
    $offset = strlen(dirname($_SERVER["SCRIPT_NAME"] ?? null));
    $path   = substr($_SERVER["REQUEST_URI"] ?? "", $offset);

    return $path ? $path : "";
}


/**
 * Render the view and return its rendered content.
 *
 * @param string $template to use when rendering the view.
 * @param array  $data     send to as variables to the view.
 *
 * @return string with the route path requested.
 */
function renderView(
    string $template,
    array $data = []
): string {
    extract($data);

    ob_start();
    require INSTALL_PATH . "/view/$template";
    $content = ob_get_contents();
    ob_end_clean();

    return ($content ? $content : "");
}


/**
 * Use Twig to render a view and return its rendered content.
 *
 * @param string $template to use when rendering the view.
 * @param array  $data     send to as variables to the view.
 *
 * @return string with the route path requested.
 */
function renderTwigView(
    string $template,
    array $data = []
): string {
    static $loader = null;
    static $twig = null;

    if (is_null($twig)) {
       $loader = new FilesystemLoader(
           INSTALL_PATH . "/view/twig"
       );
       // $twig = new \Twig\Environment($loader, [
       //     "cache" => INSTALL_PATH . "/cache/twig",
       // ]);
       $twig = new Environment($loader);
    }

    return $twig->render($template, $data);
}



// /**
//  * Send a response to the client.
//  *
//  * @param int    $status   HTTP status code to send to client.
//  *
//  * @return void
//  */
// function sendResponse(string $body, int $status = 200): void
// {
//     http_response_code($status);
//     echo $body;
// }
//
//
//
// /**
//  * Redirect to an url.
//  *
//  * @param string $url where to redirect.
//  *
//  * @return void
//  */
// function redirectTo(string $url): void
// {
//     http_response_code(200);
//     header("Location: $url");
// }



/**
 * Create an url into the website using the path and prepend the baseurl
 * to the current website.
 *
 * @param string $path to use to create the url.
 *
 * @return string with the route path requested.
 */
function url(string $path): string
{
    return getBaseUrl() . $path;
}


/**
 * Get the base url from the request, relative to the htdoc/ directory.
 *
 * @return string as the base url.
 */
function getBaseUrl()
{
    static $baseUrl = null;

    if ($baseUrl) {
       return $baseUrl;
    }

    $scriptName = rawurldecode($_SERVER["SCRIPT_NAME"] ?? null);
    $path = rtrim(dirname($scriptName), "/");

    // Prepare to create baseUrl by using currentUrl
    $parts = parse_url(getCurrentUrl());

    // Build the base url from its parts
    $siteUrl = ($parts["scheme"] ?? null)
       . "://"
       . ($parts["host"] ?? null)
       . (isset($parts["port"])
           ? ":{$parts["port"]}"
           : "");
    $baseUrl = $siteUrl . $path;

    return $baseUrl;
}


/**
 * Get the current url of the request.
 *
 * @return string as current url.
 */
function getCurrentUrl(): string
{
    $scheme = $_SERVER["REQUEST_SCHEME"] ?? "";
    $server = $_SERVER["SERVER_NAME"] ?? "";

    $port  = $_SERVER["SERVER_PORT"] ?? "";
    $port  = ($port === "80")
       ? ""
       : (($port === 443 && ($_SERVER["HTTPS"] ?? null) === "on")
           ? ""
           : ":" . $port);

    $uri = rtrim(rawurldecode($_SERVER["REQUEST_URI"] ?? ""), "/");

    $url  = htmlspecialchars($scheme) . "://";
    $url .= htmlspecialchars($server)
       . $port . htmlspecialchars(rawurldecode($uri));

    return $url;
}


/**
 * Destroy the session.
 *
 * @return void
 */
function destroySession(): void
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
       $params = session_get_cookie_params();
       setcookie(
           session_name(),
           '',
           time() - 42000,
           $params["path"],
           $params["domain"],
           $params["secure"],
           $params["httponly"]
       );
    }

    session_destroy();
}

function happySession($message): void
{
    new Dice();
    new DiceGraphic();

    if ($message === "dice1") {
        $diceHand = new DiceHand(0);
        $testFunc = $_SESSION["currentRoll"] ?? 0;
        $diceHand->roll();
        $_SESSION["currentRoll"] = $diceHand->getSum() + ($_SESSION["currentRoll"] ?? 0);
        $_SESSION["flashmessage"] = $diceHand->printRoll();
        if ($_SESSION["currentRoll"] == 21 || $testFunc == 21) {
            $_SESSION["manWin"] = 1 + ($_SESSION["manWin"] ?? 0);
            $_SESSION["status"] = "You Won!";
            $_SESSION["currentRoll"] = 0;
        } elseif ($_SESSION["currentRoll"] > 21) {
            $_SESSION["compWin"] = 1 + ($_SESSION["compWin"] ?? 0);
            $_SESSION["status"] = "You Lost!";
            $_SESSION["currentRoll"] = 0;
        }
    } elseif ($message === "dice2") {
        $diceHand = new DiceHand(1);
        $testFunc = $_SESSION["currentRoll"] ?? 0;
        $diceHand->roll();
        $_SESSION["currentRoll"] = $diceHand->getSum() + ($_SESSION["currentRoll"] ?? 0);
        $_SESSION["flashmessage"] = $diceHand->printRoll();
        if ($_SESSION["currentRoll"] == 21 || $testFunc == 21) {
            $_SESSION["manWin"] = 1 + ($_SESSION["manWin"] ?? 0);
            $_SESSION["status"] = "You Won!";
            $_SESSION["currentRoll"] = 0;
        } elseif ($_SESSION["currentRoll"] > 21) {
            $_SESSION["compWin"] = 1 + ($_SESSION["compWin"] ?? 0);
            $_SESSION["status"] = "You Lost!";
            $_SESSION["currentRoll"] = 0;
        }
    } elseif ($message === "stop") {
        $roboHand = new Rounds();
        $temp = $_SESSION["currentRoll"] ?? 0;
        $roboHand->curRoll($temp);
        $moreAndLess = ($roboHand->roboSum() > $temp && $roboHand->roboSum() <= 21);
        if ($roboHand->roboSum() > 21 || $temp == 21) {
            $_SESSION["status"] = "You Won!";
            $_SESSION["roboSum"] = $roboHand->roboSum();
            $_SESSION["manWin"] = 1 + ($_SESSION["manWin"] ?? 0);
            $_SESSION["currentRoll"] = 0;
        } elseif ($moreAndLess) {
            $_SESSION["status"] = "Computer Won!";
            $_SESSION["roboSum"] = $roboHand->roboSum();
            $_SESSION["compWin"] = 1 + ($_SESSION["compWin"] ?? 0);
            $_SESSION["currentRoll"] = 0;
        }
    }
}

function objectCreator()
{
    $die = new Dice();
    $dice = new DiceGraphic();
    $diceHand = new DiceHand(4);
    $_SESSION['diceHand'] = serialize($diceHand);
    $_SESSION['die'] = serialize($die);
    $_SESSION['dice'] = serialize($dice);
    if (!isset($_SESSION['rounds'])) {
        $rounds = new Rounds();
        $_SESSION['rounds'] = serialize($rounds);
    }
}

function yatzy($givenOption = "none", $reRollDice = null): void
{
    $gDie = unserialize($_SESSION['die']);
    $gDice = unserialize($_SESSION['dice']);
    $diceHand = unserialize($_SESSION['diceHand']);

    if ($givenOption == "roll") {
        $diceHand->roll();
        $_SESSION["testing"] = $diceHand->printRoll();
    } else if ($givenOption == "none") {
        $diceHand->getDice($reRollDice);
        $_SESSION["testing2"] = $diceHand->printRoll();
    }

    $_SESSION["diceHand"] = serialize($diceHand);
    $_SESSION["dice"] = serialize($gDice);
    $_SESSION["die"] = serialize($gDie);
}

function gameOver()
{
    unserialize($_SESSION['die']);
    unserialize($_SESSION['dice']);
    $diceHand = unserialize($_SESSION['diceHand']);
    $rounds = unserialize($_SESSION['rounds']);
    if ($rounds->rolledRounds() < 6) {
        $rounds->addRound(1);
        $rounds->addRoundHand($diceHand->printRoll());
    }
    $sum = $rounds->rolledRounds();
    $_SESSION['rounds'] = serialize($rounds);
    return $sum;
}
