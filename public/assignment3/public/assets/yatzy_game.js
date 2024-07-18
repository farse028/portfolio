import Dice from "./dice.js";

class YatzyGame {
    constructor() {
        this.rollsRemaining = 2;
        this.dices = [];
        for (let i = 0; i < 5; i++) {
            this.dices.push(new Dice(i, this));
        }
        this.keepState = [false, false, false, false, false]; // Keep / re-roll state of each dice
        this.scoreState = {
            //upper section
            ones: null,
            twos: null,
            threes: null,
            fours: null,
            fives: null,
            sixes: null,

            // lower section
            onePair: null,
            twoPairs: null,
            threeOfAKind: null,
            fourOfAKind: null,
            smallStraight: null,
            largeStraight: null,
            fullHouse: null,
            chance: null,
            yatzy: null
        }
    }


    rollDice() {
        // Roll the dice that are not kept
        if (this.rollsRemaining > 0) {
            for (let i = 0; i < this.dices.length; i++) {
                if (!this.keepState[i]) {
                    this.dices[i].roll();
                }
            }
            this.rollsRemaining--;
        }
    }

    getDice() {
        let res = []
        for (let i = 0; i < this.dices.length; i++) {
            res.push(this.dices[i].getState());
        }
        return res;
    }

    selectScore(scoreMethod) {
        if (this.scoreState[scoreMethod] === null) {
            let funcName = scoreMethod.charAt(0).toUpperCase() + scoreMethod.slice(1)
            let func = `calculate${funcName}(this.getDice())`
            this.scoreState[scoreMethod] = eval(func);
            // if success -> reset the users turn
            this.resetTurn()
        }
    }

    toggleKeep(index) {
        // Toggle the keep state of a die at the given index
        this.keepState[index] = !this.keepState[index];
    }

    resetTurn() {
        // Reset the turn to its initial state
        this.rollsRemaining = 2;
        this.keepState = [false, false, false, false, false]; // Keep / re-roll state of each dice
        this.dices = [];
        for (let i = 0; i < 5; i++) {
            this.dices.push(new Dice(i, this));
        }
    }
}

export default YatzyGame;
  