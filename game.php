<?php
declare(strict_types=1);
require "Blackjack.php";

//DISPLAY ERRORS
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

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

session_start();
if (empty($_POST)){
    $player = new Blackjack(0, true);
    $dealer = new Blackjack(0, false);

    $_SESSION["player"] = $player;
    $_SESSION["dealer"] = $dealer;

} else {
    if (!empty($_POST["hit"])){

        $player = $_SESSION["player"];
        $dealer = $_SESSION["dealer"];

        $player->hit();
    }
    elseif (!empty($_POST["stand"])){

        $player = $_SESSION["player"];
        $dealer = $_SESSION["dealer"];

    }
    else {
        echo "SURRENDER";

        $player = $_SESSION["player"];
        $dealer = $_SESSION["dealer"];

        $player->surrender();

    }
}




whatIsHappening();

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
    <h1>Player</h1>
    <h3>
        hand: <?php echo $player->getScore();?>
    </h3>

    <h1>Dealer</h1>
    <h3>
        hand: <?php echo $dealer->getScore();?>
    </h3>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <button type="submit" class="btn btn-success" name="hit" value="hit">Hit</button>
        <button type="submit" class="btn btn-primary" name="stand" value="stand">Stand</button>
        <button type="submit" class="btn btn-danger" name="surrender" value="surrender">Surrender</button>
    </form>
</body>