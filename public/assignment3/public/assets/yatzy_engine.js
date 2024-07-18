function calculateOnes(diceState) {
    let score = 0;
    for (let i = 0; i < diceState.length; i++) {
        if (diceState[i] === 1) {
            score += diceState[i];
        }
    }
    return score;
}

function calculateTwos(diceState) {
    let score = 0;
    for (let i = 0; i < diceState.length; i++) {
        if (diceState[i] === 2) {
            score += diceState[i];
        }
    }
    return score;
}

function calculateThrees(diceState) {
    let score = 0;
    for (let i = 0; i < diceState.length; i++) {
        if (diceState[i] === 3) {
            score += diceState[i];
        }
    }
    return score;
}

function calculateFours(diceState) {
    let score = 0;
    for (let i = 0; i < diceState.length; i++) {
        if (diceState[i] === 4) {
            score += diceState[i];
        }
    }
    return score;
}

function calculateFives(diceState) {
    let score = 0;
    for (let i = 0; i < diceState.length; i++) {
        if (diceState[i] === 5) {
            score += diceState[i];
        }
    }
    return score;
}

function calculateSixes(diceState) {
    let score = 0;
    for (let i = 0; i < diceState.length; i++) {
        if (diceState[i] === 6) {
            score += diceState[i];
        }
    }
    return score;
}

function calculateOnePair(diceState) {
    // sort in descending order
    diceState.sort((a, b) => b - a);
    let l = 0
    for (let r = 1; r < diceState.length; l++, r++) {
        // if a pair is found it is the max sum pair
        if (diceState[r] === diceState[l]) {
            return diceState[r] * 2;
        }
    }
    return 0;
}

function calculateTwoPairs(diceState) {
    // sort in descending order
    diceState.sort((a, b) => b - a);

    let pairsFound = 0;
    let score = 0;
    let l = 0
    for (let r = 1; r < diceState.length; l++, r++) {
        // if a pair is found it is the max sum pair
        if (diceState[r] === diceState[l]) {
            score += diceState[l] * 2;

            // if two pairs found return them (it is the max)
            if (++pairsFound === 2) {
                return score;
            }


            // need to find new numbers (pairs must be distinct)
            while (r < diceState.length && diceState[r] === diceState[l]) {
                r++;
            }
            // make left pointer 1 lower than the right pointer
            l = r - 1;
        }
    }
    return 0;
}

// console.log(calculateTwoPairs([1,1,1,1,5]));
// console.log(calculateTwoPairs([1,1,2,2,5]));
// console.log(calculateTwoPairs([6,1,2,2,6]));

function calculateThreeOfAKind(diceState) {
    // this works because there is 5 dice
    let numCount = new Map();
    for (let i = 0; i < diceState.length; i++) {
        let count = numCount.has(diceState[i]) ? numCount.get(diceState[i]) + 1 : 1;

        // if number appears three times
        if (count === 3) {
            return diceState[i] * 3;
        }
        numCount.set(diceState[i], count);
    }
    return 0;
}

function calculateFourOfAKind(diceState) {
    // this works because there is 5 dice
    let numCount = new Map();
    for (let i = 0; i < diceState.length; i++) {
        let count = numCount.has(diceState[i]) ? numCount.get(diceState[i]) + 1 : 1;

        if (count === 4) {
            return diceState[i] * 4;
        }
        numCount.set(diceState[i], count);
    }
    return 0;
}

function calculateSmallStraight(diceState) {
    let nums = new Set(diceState);
    // check if the set has numbers 1-5
    for (let i = 1; i <= 5; i++) {
        if (!nums.has(i)) {
            return 0;
        }
    }
    return 15;
}

function calculateLargeStraight(diceState) {
    let nums = new Set(diceState);
    // check if the set has numbers 2-6
    for (let i = 2; i <= 6; i++) {
        if (!nums.has(i)) {
            return 0;
        }
    }
    return 20;
}

function calculateFullHouse(diceState) {
    // full house = three of a kind + a two of a kind that are distinct
    let numCount = new Map();

    // get count of each number
    for (let i = 0; i < diceState.length; i++) {
        let count = numCount.has(diceState[i]) ? numCount.get(diceState[i]) + 1 : 1;
        numCount.set(diceState[i], count);
    }

    let score = 0;
    for (let [num, count] of numCount) {
        if (count !== 2 && count!== 3) {
            return 0;
        }
        score += num * count;
    }

    return score;
}

// console.log(calculateFullHouse([1,2,3,4,5]))
// console.log(calculateFullHouse([1,1,3,3,3]))
// console.log(calculateFullHouse([6,5,5,6,5]))

function calculateChance(diceState) {
    let score = 0;
    for (let i = 0; i < diceState.length; i++) {
        score += diceState[i];
    }
    return score;
}

function calculateYatzy(diceStates) {
    for (let i = 1; i < diceStates.length; i++) {
        if (diceStates[i] !== diceStates[i - 1]) {
            return 0;
        }
    }
    return 50;
}


function calculateUpperSum(gameState) {
    // null = 0 in js so this works
    return gameState['ones'] + gameState['twos'] + gameState['threes'] + gameState['fours'] + gameState['fives'] + gameState['sixes'];
}

function calculateBonus(gameState) {
    // if upper section score is 63+ -> give bonus
    return calculateUpperSum(gameState) >= 63 ? 50 : 0
}

function calculateTotal(gameState) {
    let total = 0;

    for (const value of Object.values(gameState)) {
       total += value;
    }

    total += calculateBonus(gameState);

    return total;
}