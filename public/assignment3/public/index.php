<?php
require_once('_config.php');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Yatzy\Dice;
use Yatzy\YatzyGame;

// make game in session
session_start();

//$_SESSION["leaderBoard"] = array();s
if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new YatzyGame();
}

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $view = file_get_contents("{$GLOBALS["appDir"]}/views/game.html");
    $response->getBody()->write($view);
    return $response;
});

$app->get('/api/version', function (Request $request, Response $response, $args) {
    // fill me in
    $data = ["version" => "1.0"];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/leaderboard', function (Request $request, Response $response, $args) {
    $leaderboard = $_SESSION["game"]->getLeaderboard();
    $response->getBody()->write(json_encode($leaderboard));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/leaderboard/{n}', function (Request $request, Response $response, $args) {

    $leaderboard = $_SESSION["game"]->getLeaderboard();
    $leaderboard = array_slice($leaderboard, 0, $args['n']);
    $response->getBody()->write(json_encode($leaderboard));
    return $response->withHeader('Content-Type', 'application/json');
});



$app->get('/api/roll', function (Request $request, Response $response, $args) {
    // fill me in
//    $d = new Dice();
//    $data = ["value" => $d->roll()];
//    $response->getBody()->write(json_encode($data));
//    return $response->withHeader('Content-Type', 'application/json');
    $dice = $_SESSION["game"]->roll();

    for ($i = 0; $i < count($dice); $i++) {
        $dice[$i] = $dice[$i]->getState();
    }
    $response->getBody()->write(json_encode($dice));
    return $response->withHeader('Content-Type', 'application/json');
});


$app->get('/api/score', function (Request $request, Response $response, $args) {
    $score = $_SESSION["game"]->getScore();
    $response->getBody()->write(json_encode($score));
    return $response->withHeader('Content-Type', 'application/json');
});

// get info about state of game:
// rolls remaining for turn
// scorecard
// dice states + numbers
$app->get('/api/game', function (Request $request, Response $response, $args) {
    $data = [
        "score" => $_SESSION["game"]->getScore(),
        "rolls" => $_SESSION["game"]->getRollsRemaining(),
        "dice" => $_SESSION["game"]->getDice()
    ];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});


$app->post('/api/toggleDice/{id}', function (Request $request, Response $response, $args) {
    // ensure id is in range!
    if ($args['id'] > 4 || $args['id'] < 0) {
        return $response->withStatus(400, "id is out of range");
    }
    $_SESSION["game"]->toggleKeeper($args['id']);
    $response->getBody()->write(json_encode(["state" => $_SESSION["game"]->getKeepers()[$args['id']]]));
    return $response->withHeader('Content-Type', 'application/json');
});

// put method to update score
$app->put('/api/choose/{scoringMethod}', function (Request $request, Response $response, $args) {
    $message = $_SESSION["game"]->chooseScoringMethod($args['scoringMethod']);
    $response->getBody()->write(json_encode(["message" => $message]));

    if ($message !== "successfully updated score") {
        return $response->withStatus(400, $message);
    }

    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/newGame', function (Request $request, Response $response, $args) {
   $_SESSION["game"]->newGame();
});

$app->run();
//run////
//session_destroy();

//<!--// prev lab-->
//<!--//require_once('_config.php');-->
//<!--//-->
//<!--//use Yatzy\Dice;-->
//<!--//use Yatzy\YatzyGame;-->
//<!--//-->
//<!--////$d = new Dice();-->
//<!--//-->
//<!--////for ($i=1; $i<=5; $i++) {-->
//<!--////    echo "ROLL {$i}: {$d->roll()}<br>";-->
//<!--////}-->
//<!--//-->
//<!--//// testing the game-->
//<!--//$game = new YatzyGame();-->
//<!--//echo $game;-->
//<!--//$game->roll();-->
//<!--//echo $game;-->
//<!--//// note the function takes the index of the dice to toggle (different from the visual dice num).-->
//<!--//$game->toggleKeeper(1);-->
//<!--//$game->toggleKeeper(2);-->
//<!--//$game->roll();-->
//<!--//echo $game;-->
