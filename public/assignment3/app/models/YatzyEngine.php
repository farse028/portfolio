<?php
//namespace Yatzy;

function calculateOnes($diceState): int
{
    $score = 0;
    for ($i = 0; $i < count($diceState); $i++) {
        if ($diceState[$i] === 1) {
            $score += $diceState[$i];
        }
    }
    return $score;
}

function calculateTwos($diceState): int
{
    $score = 0;
    for ($i = 0; $i < count($diceState); $i++) {
        if ($diceState[$i] === 2) {
            $score += $diceState[$i];
        }
    }
    return $score;
}

function calculateThrees($diceState): int
{
    $score = 0;
    for ($i = 0; $i < count($diceState); $i++) {
        if ($diceState[$i] === 3) {
            $score += $diceState[$i];
        }
    }
    return $score;
}


function calculateFours($diceState): int
{
    $score = 0;
    for ($i = 0; $i < count($diceState); $i++) {
        if ($diceState[$i] === 4) {
            $score += $diceState[$i];
        }
    }
    return $score;
}

function calculateFives($diceState): int
{
    $score = 0;
    for ($i = 0; $i < count($diceState); $i++) {
        if ($diceState[$i] === 5) {
            $score += $diceState[$i];
        }
    }
    return $score;
}

function calculateSixes($diceState): int
{
    $score = 0;
    for ($i = 0; $i < count($diceState); $i++) {
        if ($diceState[$i] === 6) {
            $score += $diceState[$i];
        }
    }
    return $score;
}

function calculateOnePair($diceState): int
{
    // sort in descending order
    rsort($diceState);
    $l = 0;
    for ($r = 1; $r < count($diceState); $l++, $r++) {
        // if a pair is found, it is the max sum pair
        if ($diceState[$r] === $diceState[$l]) {
            return $diceState[$r] * 2;
        }
    }
    return 0;
}

function calculateTwoPairs($diceState)
{
    // sort in descending order
    rsort($diceState);

    $pairsFound = 0;
    $score = 0;
    $l = 0;
    for ($r = 1; $r < count($diceState); $l++, $r++) {
        // if a pair is found, it is the max sum pair
        if ($diceState[$r] === $diceState[$l]) {
            $score += $diceState[$l] * 2;

            // if two pairs found return them (it is the max)
            if (++$pairsFound === 2) {
                return $score;
            }


            // need to find new numbers (pairs must be distinct)
            while ($r < count($diceState) && $diceState[$r] === $diceState[$l]) {
                $r++;
            }
            // make left pointer 1 lower than the right pointer
            $l = $r - 1;
        }
    }
    return 0;
}

//// console.log(calculateTwoPairs([1,1,1,1,5]));
//// console.log(calculateTwoPairs([1,1,2,2,5]));
//// console.log(calculateTwoPairs([6,1,2,2,6]));
//

function calculateThreeOfAKind($diceState): int
{
    $numCount = array_count_values($diceState);
    // sort by key in descending order
    krsort($numCount);

    foreach ($numCount as $value => $count) {
        if ($count >= 3) {
            return $value * 3;
        }
    }

    return 0;
}

//echo calculateThreeOfAKind([6, 6, 2, 2, 6]);

function calculateFourOfAKind($diceState): int
{
    $numCount = array_count_values($diceState);
    krsort($numCount);

    foreach ($numCount as $value => $count) {
        if ($count >= 4) {
            return $value * 4;
        }
    }

    return 0;
}

function calculateSmallStraight($diceState): int
{
    // check if the set has numbers 1-5
    for ($i = 1; $i <= 5; $i++) {
        if (!in_array($i, $diceState)) {
            return 0;
        }
    }
    return 15;
}

//echo calculateSmallStraight([1, 2, 3, 4, 6, 5]);


function calculateLargeStraight($diceState): int
{
    // check if the set has numbers 2-6
    for ($i = 2; $i <= 6; $i++) {
        if (!in_array($i, $diceState)) {
            return 0;
        }
    }
    return 20;
}

function calculateFullHouse($diceState)
{
    // full house = three of a kind + a two of a kind that are distinct

    $numCount = array_count_values($diceState);
    $score = 0;

    foreach ($numCount as $value => $count) {
        // if count is not 2 or 3 then cannot be full house
        if ($count !== 2 && $count !== 3) {
            return 0;
        }
        $score += $value * $count;
    }

    return $score;
}

//// console.log(calculateFullHouse([1,2,3,4,5]))
//// console.log(calculateFullHouse([1,1,3,3,3]))
//// console.log(calculateFullHouse([6,5,5,6,5]))

function calculateChance($diceState) {
    $score = 0;
    for ($i = 0; $i < count($diceState); $i++) {
        $score += $diceState[$i];
    }
    return $score;
}

function calculateYatzy($diceStates): int {
    for ($i = 1; $i < count($diceStates); $i++) {
        if ($diceStates[$i] !== $diceStates[$i - 1]) {
            return 0;
        }
    }
    return 50;
}

function calculateUpperSum($gameState) {
    // null = 0 in js so this works
    $sum = 0;
    if ($gameState['ones']['chosen']) {
        $sum += $gameState['ones']['score'];
    }

    if ($gameState['twos']['chosen']) {
        $sum += $gameState['twos']['score'];
    }

    if ($gameState['threes']['chosen']) {
        $sum += $gameState['threes']['score'];
    }

    if ($gameState['four']['chosen']) {
        $sum += $gameState['fours']['score'];
    }

    if ($gameState['fives']['chosen']) {
        $sum += $gameState['fives']['score'];
    }

    if ($gameState['sixes']['chosen']) {
        $sum += $gameState['sixes']['score'];
    }

    return $sum;
}

function calculateBonus($gameState): int {
    // if upper section $score is 63+ -> give bonus
    return calculateUpperSum($gameState) >= 63 ? 50 : 0;
}

function calculateTotal($gameState) {
    $total = 0;

    forEach ($gameState as $method => $score) {
        $total += $score;
    }

    $total += calculateBonus($gameState);

    return $total;
}