<?php

namespace Yatzy;

use Yatzy\Dice;

require_once('YatzyEngine.php');

class YatzyGame
{
    // made public to simplify unit tests (no need to make a getter/setter for each variable)
    public $rollsRemaining;
    public $diceStates;
    public $keepers;
    public $scoreState;
    public $leaderBoard;

    public function __construct()
    {
        $this->leaderBoard = array();
        $this->resetGame();
    }

    public function getDiceValues(): array
    {
        $values = array();
        for ($i = 0; $i < count($this->diceStates); $i++) {
            $values[$i] = $this->diceStates[$i]->getState();
        }
        return $values;
    }

    /**
     * @return Dice[]
     */
    public function getDiceStates(): array
    {
        return $this->diceStates;
    }

    /**
     * @return Dice[]
     */
    public function getKeepers(): array
    {
        return $this->keepers;
    }

    /**
     * @return int
     */
    public function getRollsRemaining(): int
    {
        return $this->rollsRemaining;
    }

    /**
     * @return array[]
     */
    public function getScore(): array
    {
        $total = 0;
        // update score card
        foreach ($this->scoreState as $scoringMethod => $data) {
            if ($scoringMethod !== "upperScore" && $scoringMethod !== "bonus" && $scoringMethod !== "total") {
                if (!$data["chosen"]) {
                    $this->scoreState[$scoringMethod]["score"] = call_user_func("calculate" . ucfirst($scoringMethod), $this->getDiceValues());
                } else {
                    $total += $data["score"];
                }
            }
        }

        $this->scoreState["total"] = $total + $this->scoreState["bonus"];
        return $this->scoreState;
    }

    public function getDice(): array
    {
        $dice = array(1, 2, 3, 4, 5);
        for ($i = 0; $i < count($dice); $i++) {
            $dice[$i] = ["keeper" => $this->keepers[$i], "value" => $this->diceStates[$i]->getState()];
        }
        return $dice;
    }


    public function newGame()
    {
        $score = $this->scoreState["total"];
        array_push($this->leaderBoard, $score);
        // reset everything about the game except the leaderboard
        $this->resetGame();
    }

    public function getLeaderBoard(): array
    {
        rsort($this->leaderBoard);
        return $this->leaderBoard;
    }

    public function roll(): array
    {
        if ($this->rollsRemaining <= 0) {
            // cannot roll
            return $this->diceStates;
        } else {
            $this->rollsRemaining--;
            for ($i = 0; $i < count($this->diceStates); $i++) {
                if (!$this->keepers[$i]) {
                    $this->diceStates[$i]->roll();
                }
            }
        }

        return $this->diceStates;
    }

    public function toggleKeeper($diceNum)
    {
        // assumes it is in range
        $this->keepers[$diceNum] = !$this->keepers[$diceNum];
    }

    public function resetTurn()
    {
        $this->rollsRemaining = 2;
        $this->diceStates = [new Dice(), new Dice(), new Dice(), new Dice(), new Dice()];
        $this->keepers = [false, false, false, false, false];
    }

    public function chooseScoringMethod($methodName): string
    {
        switch ($methodName) {
            case "ones":
                if (!$this->scoreState["ones"]["chosen"]) {
                    $this->scoreState["ones"]["chosen"] = true;
                    $this->scoreState["ones"]["score"] = calculateOnes($this->getDiceValues());
                    $this->scoreState["upperScore"] += $this->scoreState["ones"]["score"];
                    $this->scoreState["bonus"] = $this->scoreState["upperScore"] >= 63 ? 50 : 0;
                } else {
                    return "Already chosen";
                }
                break;
            case "twos":
                if (!$this->scoreState["twos"]["chosen"]) {
                    $this->scoreState["twos"]["chosen"] = true;
                    $this->scoreState["twos"]["score"] = calculateTwos($this->getDiceValues());
                    $this->scoreState["upperScore"] += $this->scoreState["twos"]["score"];
                    $this->scoreState["bonus"] = $this->scoreState["upperScore"] >= 63 ? 50 : 0;
                } else {
                    return "Already chosen";
                }
                break;
            case "threes":
                if (!$this->scoreState["threes"]["chosen"]) {
                    $this->scoreState["threes"]["chosen"] = true;
                    $this->scoreState["threes"]["score"] = calculateThrees($this->getDiceValues());
                    $this->scoreState["upperScore"] += $this->scoreState["threes"]["score"];
                    $this->scoreState["bonus"] = $this->scoreState["upperScore"] >= 63 ? 50 : 0;
                } else {
                    return "Already chosen";
                }
                break;
            case "fours":
                if (!$this->scoreState["fours"]["chosen"]) {
                    $this->scoreState["fours"]["chosen"] = true;
                    $this->scoreState["fours"]["score"] = calculateFours($this->getDiceValues());
                    $this->scoreState["upperScore"] += $this->scoreState["fours"]["score"];
                    $this->scoreState["bonus"] = $this->scoreState["upperScore"] >= 63 ? 50 : 0;
                } else {
                    return "Already chosen";
                }
                break;
            case "fives":
                if (!$this->scoreState["fives"]["chosen"]) {
                    $this->scoreState["fives"]["chosen"] = true;
                    $this->scoreState["fives"]["score"] = calculateFives($this->getDiceValues());
                    $this->scoreState["upperScore"] += $this->scoreState["fives"]["score"];
                    $this->scoreState["bonus"] = $this->scoreState["upperScore"] >= 63 ? 50 : 0;
                } else {
                    return "Already chosen";
                }
                break;
            case "sixes":
                if (!$this->scoreState["sixes"]["chosen"]) {
                    $this->scoreState["sixes"]["chosen"] = true;
                    $this->scoreState["sixes"]["score"] = calculateSixes($this->getDiceValues());
                    $this->scoreState["upperScore"] += $this->scoreState["sixes"]["score"];
                    $this->scoreState["bonus"] = $this->scoreState["upperScore"] >= 63 ? 50 : 0;
                } else {
                    return "Already chosen";
                }
                break;
            case "onePair":
                if (!$this->scoreState["onePair"]["chosen"]) {
                    $this->scoreState["onePair"]["chosen"] = true;
                    $this->scoreState["onePair"]["score"] = calculateOnePair($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            case "twoPairs":
                if (!$this->scoreState["twoPairs"]["chosen"]) {
                    $this->scoreState["twoPairs"]["chosen"] = true;
                    $this->scoreState["twoPairs"]["score"] = calculateTwoPairs($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            case "threeOfAKind":
                if (!$this->scoreState["threeOfAKind"]["chosen"]) {
                    $this->scoreState["threeOfAKind"]["chosen"] = true;
                    $this->scoreState["threeOfAKind"]["score"] = calculateThreeOfAKind($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            case "fourOfAKind":
                if (!$this->scoreState["fourOfAKind"]["chosen"]) {
                    $this->scoreState["fourOfAKind"]["chosen"] = true;
                    $this->scoreState["fourOfAKind"]["score"] = calculateFourOfAKind($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            case "smallStraight":
                if (!$this->scoreState["smallStraight"]["chosen"]) {
                    $this->scoreState["smallStraight"]["chosen"] = true;
                    $this->scoreState["smallStraight"]["score"] = calculateSmallStraight($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            case "largeStraight":
                if (!$this->scoreState["largeStraight"]["chosen"]) {
                    $this->scoreState["largeStraight"]["chosen"] = true;
                    $this->scoreState["largeStraight"]["score"] = calculateLargeStraight($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            case "fullHouse":
                if (!$this->scoreState["fullHouse"]["chosen"]) {
                    $this->scoreState["fullHouse"]["chosen"] = true;
                    $this->scoreState["fullHouse"]["score"] = calculateFullHouse($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            case "chance":
                if (!$this->scoreState["chance"]["chosen"]) {
                    $this->scoreState["chance"]["chosen"] = true;
                    $this->scoreState["chance"]["score"] = calculateChance($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            case "yatzy":
                if (!$this->scoreState["yatzy"]["chosen"]) {
                    $this->scoreState["yatzy"]["chosen"] = true;
                    $this->scoreState["yatzy"]["score"] = calculateYatzy($this->getDiceValues());
                } else {
                    return "Already chosen";
                }
                break;
            default:
                return "method does not exist";
        }

        $this->resetTurn();
        return "successfully updated score";
    }

    public function __toString(): string
    {
        $out = "Roll number: {$this->rollsRemaining}<br>";
        $i = 0;

        foreach ($this->diceStates as $diceState) {
            ++$i;
            $out .= "DICE {$i}: {$diceState->getState()}<br>";
        }

        return $out;
    }

    /**
     * @return void
     */
    public function resetGame(): void
    {
        $this->rollsRemaining = 2;
        $this->diceStates = [new Dice(), new Dice(), new Dice(), new Dice(), new Dice()];
        $this->keepers = [false, false, false, false, false];
        $this->scoreState = [
            //upper section
            "ones" => ["chosen" => false, "score" => 0],
            "twos" => ["chosen" => false, "score" => 0],
            "threes" => ["chosen" => false, "score" => 0],
            "fours" => ["chosen" => false, "score" => 0],
            "fives" => ["chosen" => false, "score" => 0],
            "sixes" => ["chosen" => false, "score" => 0],
            "upperScore" => 0,
            "bonus" => 0,

            // lower section
            "onePair" => ["chosen" => false, "score" => 0],
            "twoPairs" => ["chosen" => false, "score" => 0],
            "threeOfAKind" => ["chosen" => false, "score" => 0],
            "fourOfAKind" => ["chosen" => false, "score" => 0],
            "smallStraight" => ["chosen" => false, "score" => 0],
            "largeStraight" => ["chosen" => false, "score" => 0],
            "fullHouse" => ["chosen" => false, "score" => 0],
            "chance" => ["chosen" => false, "score" => 0],
            "yatzy" => ["chosen" => false, "score" => 0],
            "total" => 0
        ];
    }
}
