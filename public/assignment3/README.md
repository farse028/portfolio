# Yatzy game
[Design System](docs/design_system.md)

## Running the game
1. Ensure node.js is installed (to use npm)
2. In the root directory run npx http-server. This will start a server on localhost:8080.
   To view the website visit localhost:8080/test.html

## Rules
You have up to 3 rolls per turn. In each turn you can choose which dice you keep (the rest are rerolled).
During each turn you must choose a method to [score](#Scoring) as described below. Each scoring method must be used only once per game.
### Scoring
#### Upper Section
- Ones: The sum of all dice showing the number 1.
- Twos: The sum of all dice showing the number 2.
- Threes: The sum of all dice showing the number 3.
- Fours: The sum of all dice showing the number 4.
- Fives: The sum of all dice showing the number 5.
- Sixes: The sum of all dice showing the number 6.

A bonus of 50 points is awarded if the sum of the upper section is 63 or larger. 

#### Lower Section
- One Pair: Two dice showing the same number. Score: Sum of those two dice.
- Two Pairs: Two different pairs of dice. Score: Sum of dice in those two pairs.
- Three of a Kind: Three dice showing the same number. Score: Sum of those three dice.
- Four of a Kind: Four dice with the same number. Score: Sum of those four dice.
- Small Straight: The combination 1-2-3-4-5. Score: 15 points (sum of all the dice).
- Large Straight: The combination 2-3-4-5-6. Score: 20 points (sum of all the dice).
- Full House: Any set of three combined with a different pair. Score: Sum of all the dice.
- Chance: Any combination of dice. Score: Sum of all the dice.
- Yatzy: All five dice with the same number. Score: 50 points.

*Note Two Pairs and Full House must have different numbers in the subsets used for the pairs. For example the combination 1-5-5-6-6 will score 22 as Two Pairs, but 1-5-5-5-5 will score nothing in that category because the two pairs must be different.

## How it Works
yatzy_game.js is a class that holds the state of the current game.
yatzy_engine.js provides yatzy_game with some helper functions.
dice.js is a dice class (current number, sides, etc) with a method to render the dice.

The game renders componets including a sidebar/header, score card, the dice, and buttons to control the dice.

Dice in the game are 9x9 HTML grids with dots that are rendered in the correct location based on a JSON object with arrays of booleans signifying where the dots should go based on the number. 
When dice are rendered they are given a click event listener to listen if it is clicked. If it is clicked it will toggle the state of the dice so it will not be rerolled.

The new game button works by replacing the current game object with a new Yatzy_game (thus restarting the game).

The reroll button works by calling the roll dice method from the yatzy_game object which rolls the dice that are in the reroll state (which is stored in an array).

The score card works by rendering row by row. 
Using DOM a td element is created and filled with the proper data based on the sate of the yatzy_game object. if the current row being rendered has a score it is given a locked class for styling and its score is filled. Otherwise the row is filled with the calculated score based on the current state of the dice and a click event listener is given to listen if the user selects the scoring option of the current row. Then using the DOM the td created is appended to the current table row (tr).

Note after any of the click events the render method is called to re-reneder the dice and scorecard. 