<?php
declare(strict_types=1);
require "Blackjack.php";
const BLACKJACK = 21;
const DEALER_STAND = 16;

//DISPLAY ERRORS
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

//DISPLAY VALUES IN SUPERGLOBALS
function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

function displayOutcome(Blackjack $player, Blackjack $dealer) : string {
    if (!$player->getIsMyTurn()) {
        if ($player->getScore() > 21 || (
                $dealer->getScore() > $player->getScore() && $dealer->getScore() <= BLACKJACK)) {
            return "Player Loses";
        } elseif ($player->getScore() == $dealer->getScore() && $player->getScore() <= BLACKJACK && empty($_POST["surrender"])) {
            return "It's a Draw";
        } elseif ($player->getScore() > $dealer->getScore() && $player->getScore() <= BLACKJACK && empty($_POST["surrender"])) {
            return "Player Wins";
        } elseif (!empty($_POST["surrender"])) {
            return "Player surrendered";
        } else return "";
    } else return "";
}

session_start();
if (empty($_POST)){ //At first page load
    $player = new Blackjack(0, true);
    $dealer = new Blackjack(0, false);

    $_SESSION["player"] = $player;
    $_SESSION["dealer"] = $dealer;

} else {
    if (!empty($_POST["hit"])){

        $player = $_SESSION["player"];
        $dealer = $_SESSION["dealer"];

        $player->hit();

        if ($player->getScore() == BLACKJACK){
            $player->stand();
            $dealer->setIsMyTurn(true);
            $dealer->hit();
            $dealer->hit();
        }
        echo "<h1>". displayOutcome($player, $dealer) ."</h1>";

    }elseif (!empty($_POST["stand"])){

        $player = $_SESSION["player"];
        $dealer = $_SESSION["dealer"];

        $player->stand();
        $dealer->setIsMyTurn(true);

        if ($player->getScore() <= BLACKJACK) {
            while ($dealer->getScore() < DEALER_STAND) {
                $dealer->hit();
            }
            $dealer->stand();
            echo "<h1>". displayOutcome($player, $dealer) ."</h1>";
        }

    }elseif (!empty($_POST["surrender"])) {

        $player = $_SESSION["player"];
        $dealer = $_SESSION["dealer"];

        $player->surrender();
        echo "<h1>". displayOutcome($player, $dealer) ."</h1>";

    }else { //basically when play again is selected
        $player = new Blackjack(0, true);
        $dealer = new Blackjack(0, false);

        $_SESSION["player"] = $player;
        $_SESSION["dealer"] = $dealer;
    }
}

//whatIsHappening();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Playing Blackjack</title>
</head>
<body>
    <h1><?php displayOutcome($player, $dealer) ?></h1>
    <h2>Player</h2>
    <h3>
        hand: <?php echo $player -> getScore();?>
    </h3>

    <h2>Dealer</h2>
    <h3>
        hand: <?php echo $dealer -> getScore();?>
    </h3>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <button type="submit" class="btn btn-success" name="hit" value="hit">Hit</button>
        <button type="submit" class="btn btn-primary" name="stand" value="stand">Stand</button>
        <button type="submit" class="btn btn-danger" name="surrender" value="surrender">Surrender</button>
        <br>
        <button type="submit" class="btn btn-secondary btn-lg mt-2" name="play again" value="play again">Play Again</button>

    </form>
</body>