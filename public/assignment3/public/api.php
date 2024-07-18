<?php
require_once('_config.php');

use Yatzy\Dice;

switch ($_GET["action"] ?? "version") {
    case "roll":
        $d = new Dice();
        $data = ["value" => $d->roll()];
        break;
    case "version":
    default:
        $data = ["version" => "1.0"];
}

header("Content-Type: application/json");
echo json_encode($data);