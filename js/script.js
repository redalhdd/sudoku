// grid variable
var table;

// game number
var gameId = 0;

// puzzle grid
var puzzle = [];

// solution grid
var solution = [];


// variable to check if "Sudoku Solver" solve the puzzle
var isSolved = false;
var canSolved = true;

// stopwatch timer variables
var timer = 0;
var pauseTimer = false;
var intervalId;
var gameOn = false;

//mistakes
var mistakes = 0;

//Score
let score = -1;



var selectedNumber = null;

var pencilOn = false;












function newGame(difficulty) {
  // get random position for numbers from '1' to '9' to generate a random puzzle
  var grid = getGridInit(); // Un peu la seed pour génerer une grille

  // prepare rows, columns and blocks to solove the initioaled grid
  var rows = grid; // Grille sous forme de ligne
  var cols = getColumns(grid); // Grille sous formes de colonne
  var blks = getBlocks(grid); // Grille sous forme de blocks

  // solve the grid section
  // generate allowed digits for each cell
  var psNum = generatePossibleNumber(rows, cols, blks);

  // solve the grid
  solution = solveGrid(psNum, rows, true);

  // reset the game state timer and remaining number
  timer = 0;
  //reset mistakes
  mistakes = 0;
  displayMistakes();
  displayLevel(difficulty);
  //for (var i in remaining) remaining[i] = 9;

  // empty cells from grid depend on difficulty
  // for now it will be:
  // 59 empty cells for very easy
  // 64 empty cells for easy
  // 69 empty cells for normal
  // 74 empty cells for hard
  // 79 empty cells for expert
  puzzle = makeItPuzzle(solution, difficulty);

  // game is on when the difficulty = [0, 4]
  gameOn = difficulty < 5 && difficulty >= 0;

  // update the UI
  ViewPuzzle(puzzle);
  //updateRemainingTable();

  // finally, start the timer
  if (gameOn) startTimer();
}



/**
 * Cette méthode creer une grille sous forme de 9 Strings, et 9 cases aléatoire sont initialisé dans la grille de façon unique
 **/

function getGridInit() {
  var rand = [];

  /*rand[i][j][k]
         |  |  |
         |  |  ∟ indice de la colonne aléatoire
         |  ∟ indice de la ligne aléatoire
        ∟ le chiffre
  */

  //Placer les chiffres de facon unique de 1 à 9 dans une case aléatoire
  for (var i = 1; i <= 9; i++) {
    var row = Math.floor(Math.random() * 9);
    var col = Math.floor(Math.random() * 9);
    var accept = true;
    for (var j = 0; j < rand.length; j++) {
      // if number exist or there is a number already located in then ignore and try again
      // Verification de l'unicité
      if ((rand[j][0] == i) || ((rand[j][1] == row) && (rand[j][2] == col))) {
        accept = false;

        // try to get a new position for this number
        i--;
        break;
      }
    }
    if (accept) {
      rand.push([i, row, col]);
    }
  }

  // Grille vide initialisée à 0
  var result = [];
  for (var i = 0; i < 9; i++) {
    var row = "000000000";
    result.push(row);
  }


  // put numbers in the grid


  /* Result est une grille representée ligne par ligne. 
     Chaque ligne est un String de 9 colonnes. 
     Pour chaque 
  */

  /*
    rand[i][0] = le chiffre
    rand[i][1] = la ligne
    rand[i][2 = la colonne
  */
  for (var i = 0; i < rand.length; i++) {
    result[rand[i][1]] = replaceCharAt(result[rand[i][1]], rand[i][2], rand[i][0]);
    // A chaque ligne de la grille result, on va venir placer dans l'indice de la la colonne le chiffre

  }

  return result;
}

// return columns from a row grid
function getColumns(grid) {
  var result = ["", "", "", "", "", "", "", "", ""];
  for (var i = 0; i < 9; i++) {
    for (var j = 0; j < 9; j++) result[j] += grid[i][j];
  }
  return result;
}

// return blocks from a row grid
function getBlocks(grid) {
  var result = ["", "", "", "", "", "", "", "", ""];
  for (var i = 0; i < 9; i++) {
    for (var j = 0; j < 9; j++)
      result[Math.floor(i / 3) * 3 + Math.floor(j / 3)] += grid[i][j];
  }
  return result;
}

// function to replace char in string
function replaceCharAt(string, index, char) {
  if (index > string.length - 1) return string;
  return string.substr(0, index) + char + string.substr(index + 1);
}



/**
 * Va servir au solveur, car la fonction spécifie toutes les valeurs possibles pour chaque case
 * @param {*} rows 
 * @param {*} columns 
 * @param {*} blocks 
 * @returns 
 */
// get allowed numbers that can be placed in each cell
function generatePossibleNumber(rows, columns, blocks) {
  var psb = [];

  // for each cell get numbers that are not viewed in a row, column or block
  // if the cell is not empty then, allowed number is the number already exist in it
  for (var i = 0; i < 9; i++) {
    for (var j = 0; j < 9; j++) {
      psb[i * 9 + j] = "";
      if (rows[i][j] != 0) {
        psb[i * 9 + j] += rows[i][j];
      } else {
        for (var k = "1"; k <= "9"; k++) {
          if (!rows[i].includes(k))
            if (!columns[j].includes(k))
              if (
                !blocks[Math.floor(i / 3) * 3 + Math.floor(j / 3)].includes(k)
              )
                psb[i * 9 + j] += k;
        }
      }
    }
  }
  return psb;
}

function solveGrid(possibleNumber, rows, startFromZero) {
  var solution = [];

  // solve Sudoku with a backtracking algorithm
  // Steps are:
  //  1.  get all allowed numbers that fit in each empty cell
  //  2.  generate all possible rows that fit in the first row depend on the allowed number list
  //` 3.  select one row from possible row list and put it in the first row
  //  4.  go to next row and find all possible number that fit in each cell
  //  5.  generate all possible row fit in this row then go to step 3 until reach the last row or there aren't any possible rows left
  //  6.  if next row hasn't any possible left then go the previous row and try the next possibility from possibility rows' list
  //  7.  if the last row has reached and a row fit in it has found then the grid has solved

  var result = nextStep(0, possibleNumber, rows, solution, startFromZero);
  if (result == 1) return solution;
}

// level is current row number in the grid
function nextStep(level, possibleNumber, rows, solution, startFromZero) {
  // get possible number fit in each cell in this row
  var x = possibleNumber.slice(level * 9, (level + 1) * 9);

  // generate possible numbers sequence that fit in the current row
  var y = generatePossibleRows(x);
  if (y.length == 0) return 0;

  // to allow check is solution is unique
  var start = startFromZero ? 0 : y.length - 1;
  var stop = startFromZero ? y.length - 1 : 0;
  var step = startFromZero ? 1 : -1;
  var condition = startFromZero ? start <= stop : start >= stop;

  // try every numbers sequence in this list and go to next row
  for (var num = start; condition; num += step) {
    var condition = startFromZero ? num + step <= stop : num + step >= stop;
    for (var i = level + 1; i < 9; i++) solution[i] = rows[i];
    solution[level] = y[num];
    if (level < 8) {

      var cols = getColumns(solution);
      var blocks = getBlocks(solution);

      var poss = generatePossibleNumber(solution, cols, blocks);
      if (nextStep(level + 1, poss, rows, solution, startFromZero) == 1)
        return 1;
    }
    if (level == 8) return 1;
  }
  return -1;
}

// generate possible numbers sequence that fit in the current row
function generatePossibleRows(possibleNumber) {
  var result = [];

  function step(level, PossibleRow) {
    if (level == 9) {
      result.push(PossibleRow);
      return;
    }

    for (var i in possibleNumber[level]) {
      if (PossibleRow.includes(possibleNumber[level][i])) continue;
      step(level + 1, PossibleRow + possibleNumber[level][i]);
    }
  }

  step(0, "");

  return result;
}

// empty cell from grid depends on the difficulty to make the puzzle
function makeItPuzzle(grid, difficulty) {
  /*
        difficulty:
        // expert   : 0;
        // hard     : 1;
        // Normal   : 2;
        // easy     : 3;
        // very easy: 4;
    */

  // empty_cell_count = 5 * difficulty + 20
  // when difficulty = 13, empty_cell_count = 85 > (81 total cells count)
  // so the puzzle is showen as solved grid
  if (!(difficulty < 5 && difficulty > -1)) difficulty = 13;
  var remainedValues = 81;
  var puzzle = grid.slice(0);

  // function to remove value from a cell and its symmetry then return remained values
  function clearValue(grid, x, y, remainedValues) {
    function getSymmetry(x, y) {
      var symX = 8 - x; //Symmetry
      var symY = 8 - y;
      return [symX, symY];
    }
    var sym = getSymmetry(x, y);
    if (grid[y][x] != 0) {
      grid[y] = replaceCharAt(grid[y], x, "0");
      remainedValues--;
      if (x != sym[0] && y != sym[1]) {
        grid[sym[1]] = replaceCharAt(grid[sym[1]], sym[0], "0");
        remainedValues--;
      }
    }
    return remainedValues;
  }

  // remove value from a cell and its symmetry to reach the expected empty cells amount
  while (remainedValues > difficulty * 5 + 20) {
    var x = Math.floor(Math.random() * 9);
    var y = Math.floor(Math.random() * 9);
    remainedValues = clearValue(puzzle, x, y, remainedValues);
  }
  return puzzle;
}

// view grid in html page
function ViewPuzzle(grid) {

  for (var i = 0; i < grid.length; i++) {
    for (var j = 0; j < grid[i].length; j++) {

      var input = table.rows[i].cells[j].getElementsByTagName("input")[0];

      addClassToCell(table.rows[i].cells[j].getElementsByTagName("input")[0]);
      if (grid[i][j] == "0") {
        input.disabled = false;
        input.value = "";
      } else {
        input.disabled = true;
        input.value = grid[i][j];
        //remaining[grid[i][j] - 1]--;
      }
    }
  }
}

// read current grid
function readInput() {
  var result = [];
  for (var i = 0; i < 9; i++) {
    result.push("");
    for (var j = 0; j < 9; j++) {
      var input = table.rows[i].cells[j].getElementsByTagName("input")[0];
      if (input.value == "" || input.value.length > 1 || input.value == "0") {
        input.value = "";
        result[i] += "0";
      } else if (input.className.includes("pencilOn")) {
        result[i] += "#";//# signifie que la case est pencilOn
      }
      else result[i] += input.value;
    }
  }
  return result;
}

// check value if it is correct or wrong
// return:
//  0 for value can't be changed
//  1 for correct value
//  2 for value that hasn't any conflict with other values
//  3 for value that conflict with value in its row, column or block
//  4 for incorect input
function checkValue(value, row, column, block, defaultValue, correctValue) {
  if (value === "" || value === "0") {
    mistakes--;
    return 0;
  }
  if (!(value > "0" && value < ":")) return 4;
  if (value === defaultValue) return 0;
  if (
    row.indexOf(value) != row.lastIndexOf(value) ||
    column.indexOf(value) != column.lastIndexOf(value) ||
    block.indexOf(value) != block.lastIndexOf(value) ||
    value !== correctValue
  ) {
    return 2;
  }

  return 1;
}

// remove old class from input and add a new class to represent current cell's state
function addClassToCell(input, className) {
  // remove old class from input
  input.classList.remove("right-cell");
  input.classList.remove("wrong-cell");

  if (className != undefined) input.classList.add(className);
}


// start stopwatch timer
function startTimer() {
  var timerDiv = document.getElementById("timer");
  clearInterval(intervalId);

  // update stopwatch value every one second
  pauseTimer = false;
  intervalId = setInterval(function () {
    if (!pauseTimer) {
      timer++;
      var min = Math.floor(timer / 60);
      var sec = timer % 60;
      timerDiv.innerText =
        (("" + min).length < 2 ? "0" + min : min) +
        ":" +
        (("" + sec).length < 2 ? "0" + sec : sec);
    }
  }, 1000);
}

// solve sudoku function
// input: changeUI boolean      true to allow function to change UI
// output:
//  0 when everything goes right
//  1 when grid is already solved
//  2 when Invalid input
//  3 when no solution
function solveSudoku(changeUI) {
  // read current state
  puzzle = readInput();

  var columns = getColumns(puzzle);
  var blocks = getBlocks(puzzle);

  // check if there is any conflict
  var errors = 0;
  var correct = 0;

  for (var i = 0; i < puzzle.length; i++) {
    for (var j = 0; j < puzzle[i].length; j++) {
      var result = checkValue(
        puzzle[i][j],
        puzzle[i],
        columns[j],
        blocks[Math.floor(i / 3) * 3 + Math.floor(j / 3)],
        -1,
        -1
      );
      correct = correct + (result === 2 ? 1 : 0);
      errors = errors + (result > 2 ? 1 : 0);
      addClassToCell(
        table.rows[i].cells[j].getElementsByTagName("input")[0],
        result > 2 ? "wrong-cell" : undefined
      );
    }
  }

  // check if invalid input
  if (errors > 0) {
    canSolved = false;
    return 2;
  }

  canSolved = true;
  isSolved = true;

  // check if grid is already solved
  if (correct === 81) {
    return 1;
  }

  //read the current time
  var time = Date.now();

  // solve the grid
  solution = solveGrid(
    generatePossibleNumber(puzzle, columns, blocks),
    puzzle,
    true
  );

  // show result
  // get time
  time = Date.now() - time;

  if (changeUI)
    document.getElementById("timer").innerText =
      Math.floor(time / 1000) + "." + ("000" + (time % 1000)).slice(-3);

  if (solution === undefined) {
    isSolved = false;
    canSolved = false;
    return 3;
  }

  if (changeUI) {
    // remaining = [0, 0, 0, 0, 0, 0, 0, 0, 0];
    //updateRemainingTable();
    ViewPuzzle(solution);
  }
  return 0;
}


// UI Comunication functions

// function that must run when document loaded
window.onload = function () {
  // assigne table to its value
  table = document.getElementById("puzzle-grid");
  // add ripple effect to all buttons in layout
  var rippleButtons = document.getElementsByClassName("button");
  for (var i = 0; i < rippleButtons.length; i++) {
    rippleButtons[i].onmousedown = function (e) {
      // get ripple effect's position depend on mouse and button position
      var x = e.pageX - this.offsetLeft;
      var y = e.pageY - this.offsetTop;

      // add div that represents the ripple
      var rippleItem = document.createElement("div");
      rippleItem.classList.add("ripple");
      rippleItem.setAttribute("style", "left: " + x + "px; top: " + y + "px");

      // if ripple item should have special color... get and apply it
      var rippleColor = this.getAttribute("ripple-color");
      if (rippleColor) rippleItem.style.background = rippleColor;
      this.appendChild(rippleItem);

      // set timer to remove the dif after the effect ends
      setTimeout(function () {
        rippleItem.parentElement.removeChild(rippleItem);
      }, 1500);
    };
  }
  for (var i = 0; i < 9; i++) {
    for (var j = 0; j < 9; j++) {
      var input = table.rows[i].cells[j].getElementsByTagName("input")[0];

      // add function to remove color from cells and update remaining numbers table when it get changed
      input.onchange = function () {
        //remove color from cell
        addClassToCell(this);
        switchInputColor(this, false);

        // check if the new value entered is allowed
        function checkInput(input) {
          if (input.value[0] < "1" || input.value[0] > "9") {
            if (input.value != "?" && input.value != "؟") {
              input.value = "";
              showAlert("only numbers [1-9] and question mark '?' are allowed!!");
              input.focus();
            }
          }
          checkButtonClick();
        }
        checkInput(this);

        //reset canSolved value when change any cell
        canSolved = true;

        //updateRemainingTable();
      };

      //change cell 'old value' when it got focused to track numbers and changes on grid
      input.onfocus = function () {
        this.oldvalue = this.value;
      };
    }
  }
};


// show hamburger menu
function HamburgerButtonClick() {
  debugger
  var div = document.getElementById("hamburger-menu");
  var menu = document.getElementById("nav-menu");
  div.style.display = "block";
  div.style.visibility = "visible";
  setTimeout(function () {
    div.style.opacity = 1;
    menu.style.left = 0;
  }, 50);
}

// start new game
var niveau = 0;
function startGameButtonClick() {
  var difficulties = document.getElementsByName("difficulty");
  // difficulty:
  //  0 expert
  //  1 hard
  //  2 normal
  //  3 easy
  //  4 very easy
  //  5 solved

  // initial difficulty to 5 (solved)
  var difficulty = 5;

  // get difficulty value
  for (var i = 0; i < difficulties.length; i++) {

    if (difficulties[i].checked) {
      newGame(4 - i);
      difficulty = i;
      niveau=difficulty;
      break;
    }
  }

  if (difficulty > 4) newGame(5);
  hideDialogButtonClick('dialog');


  // hide solver buttons
  // show other buttons
  document.getElementById("pause-btn").style.display = "block";

  // prerpare view for new game
  document.getElementById("timer").innerText = "00:00";


}

// pause \ continue button click function
function pauseGameButtonClick() {
  var img = document.getElementById("pause-img");

  // change icon and label of the button and hide or show the grid
  if (pauseTimer) {
    img.src = "pause.webp";
    table.style.opacity = 1;
  } else {
    img.src = "play.webp";
    table.style.opacity = 0;
  }

  pauseTimer = !pauseTimer;
}

// check grid if correct
function checkButtonClick() {
  // check if game is started
  if (gameOn && !pencilOn) {

    var currentGrid = [];

    // read grid status
    currentGrid = readInput();

    var columns = getColumns(currentGrid);
    var blocks = getBlocks(currentGrid);

    var currects = 0;

    // mistakes = 0;
    var mistakeDone = false;
    for (var i = 0; i < currentGrid.length; i++) {
      for (var j = 0; j < currentGrid[i].length; j++) {
        if (!(currentGrid[i][j] == "#")) {
          if (currentGrid[i][j] == "0") continue;

          // check value if it is correct or wrong
          var result = checkValue(
            currentGrid[i][j],
            currentGrid[i],
            columns[j],
            blocks[Math.floor(i / 3) * 3 + Math.floor(j / 3)],
            puzzle[i][j],
            solution[i][j]
          );

          // remove old class from input and add a new class to represent current cell's state
          addClassToCell(
            table.rows[i].cells[j].getElementsByTagName("input")[0],
            result === 1
              ? "right-cell"
              : result === 2
                ? "wrong-cell"
                : undefined
          );

          if (result === 1 || result === 0) {
            currects++;
          } else if (result === 3 || result === 2) {
            mistakeDone = true;
          }
        }

      }
    }
    if (mistakeDone) mistakes++;
    displayMistakes();


    // if all values are correct and they equal original values then game over and the puzzle has been solved
    // if all values are correct and they aren't equal original values then game over but the puzzle has not been solved yet
    if (currects === 81) {
      gameOn = false;
      pauseTimer = true;
      clearInterval(intervalId);
      calculScore();
      handleGameEnd(true);

    } else if (mistakes >= 6) {
      gameOn = false;
      pauseTimer = true;
      clearInterval(intervalId);
      calculScore();
      handleGameEnd(false);

    }
  }
}

// restart game
function restartButtonClick() {
  if (gameOn) {
    // reset mistakes
    mistakes = 0;
    displayMistakes();

    // review puzzle
    ViewPuzzle(puzzle);




    // restart the timer
    // -1 is because it take 1 sec to update the timer so it will start from 0
    timer = -1;
  }
}

// surrender
function SurrenderButtonClick() {
  if (gameOn) {
    // reset remaining number table
    //for (var i in remaining) remaining[i] = 9;

    // review puzzle
    ViewPuzzle(solution);

    // update remaining numbers table
    //updateRemainingTable();

    // stop the game
    gameOn = false;
    pauseTimer = true;
    clearInterval(intervalId);

    // mark game as solved
  }
}

// hint
function hintButtonClick() {
  if (gameOn) {
    // get list of empty cells and list of wrong cells
    var empty_cells_list = [];
    var wrong_cells_list = [];
    for (var i = 0; i < 9; i++) {
      for (var j = 0; j < 9; j++) {
        var input = table.rows[i].cells[j].getElementsByTagName("input")[0];
        if (input.value == "" || input.value.length > 1 || input.value == "0") {
          empty_cells_list.push([i, j]);
        } else {
          if (input.value !== solution[i][j]) wrong_cells_list.push([i, j]);
        }
      }
    }

    // check if gird is solved if so stop the game
    if (empty_cells_list.length === 0 && wrong_cells_list.length === 0) {
      gameOn = false;
      pauseTimer = true;
      clearInterval(intervalId);
      calculScore();
      handleGameEnd(true);
    } else {
      // add one minute to the stopwatch as a cost for given hint
      timer += 60;

      // get random cell from empty or wrong list and put the currect value in it
      var input;

      if (
        (Math.random() < 0.5 && empty_cells_list.length > 0) ||
        wrong_cells_list.length === 0
      ) {
        var index = Math.floor(Math.random() * empty_cells_list.length);
        input = table.rows[empty_cells_list[index][0]].cells[
          empty_cells_list[index][1]
        ].getElementsByTagName("input")[0];
        input.oldvalue = input.value;
        input.value =
          solution[empty_cells_list[index][0]][empty_cells_list[index][1]];

        } else {
        var index = Math.floor(Math.random() * wrong_cells_list.length);
        input = table.rows[wrong_cells_list[index][0]].cells[
          wrong_cells_list[index][1]
        ].getElementsByTagName("input")[0];
        input.oldvalue = input.value;

        input.value =
          solution[wrong_cells_list[index][0]][wrong_cells_list[index][1]];

        }

      // update remaining numbers table
      //updateRemainingTable();
    }

    // make updated cell blinking
    switchInputColor(input, true);
    var count = 0;
    for (var i = 0; i < 6; i++) {
      setTimeout(function () {
        if (count % 2 == 0) input.classList.add("right-cell");
        else input.classList.remove("right-cell");
        count++;
      }, i * 750);
    }
  }
}

function showDialogClick(dialogId) {

  var dialog = document.getElementById(dialogId);
  var dialogBox = document.getElementById(dialogId + "-box");
  dialogBox.focus();
  dialog.style.opacity = 0;
  dialogBox.style.marginTop = "-500px";
  dialog.style.display = "block";
  dialog.style.visibility = "visible";

  // to view and move the dialog to the correct position after it set visible
  dialog.style.opacity = 1;
  dialogBox.style.marginTop = "64px";

}


function hideDialogButtonClick(dialogId) {


  var dialog = document.getElementById(dialogId);
  var dialogBox = document.getElementById(dialogId + "-box");
  dialog.style.opacity = 0;
  dialogBox.style.marginTop = "-500px";

  setTimeout(function () {
    dialog.style.visibility = "collapse";
  }, 500);
}


function displayMistakes() {
  let inputMistake = document.getElementById("game-mistakes");
  inputMistake.innerText = "Erreur(s) : " + mistakes + "/6";
}


function displayLevel(difficulty) {
  let inputLevel = document.getElementById("game-level");
  inputLevel.innerText = "Level " + (5 - difficulty);
}


document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.querySelector("#leaderboard tbody");
  if (!tableBody) {
      console.error("Leaderboard table body not found.");
  } else {
      console.log("Leaderboard table body found.");
      updateLeaderboard();
  }
});

function updateLeaderboard() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "fetch_leaderboard.php", true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          const leaderboard = JSON.parse(xhr.responseText);

          // Clear the current table
          const tableBody = document.querySelector("#leaderboard tbody");
          tableBody.innerHTML = "";

          // Populate with new data
          leaderboard.forEach((player, index) => {
              const row = document.createElement("tr");
              row.innerHTML = `
                  <td>${index + 1}</td>
                  <td>${player.username}</td>
                  <td class="score">${player.score}</td>
              `;
              tableBody.appendChild(row);
          });
      }
  };
  xhr.send();
}



function calculScore() {
  // Définir un facteur de réduction basé sur la difficulté
let difficultyFactor = 1 - niveau * 0.2; // Réduction décroissante de 20% par niveau

// Calcul de la pénalité de temps avec le facteur de difficulté
let timePenalty = Math.floor((timer / 60) * 10 * difficultyFactor);

// Calcul du score
let score = 1000 - (mistakes * 100 + timePenalty);
  //let inputScore = document.getElementById("game-score");
  //inputScore.innerText = "Score : " + score;
  const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_user_score.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log("Score updated successfully");
                updateLeaderboard(); // Fetch and refresh the leaderboard
            } else {
                console.error("Failed to update score: " + response.message);
            }
        }
    };
    xhr.send(`username=${encodeURIComponent(currentUsername)}&score=${encodeURIComponent(score)}`);

}

// Get the notification element
const notification = document.getElementById('notification');

// Function to show the notification
function showNotification(message, type = 'win') {
  const notification = document.getElementById('notification');
  if (!notification) {
    console.error('Notification element is null.');
    return;
  }

  notification.textContent = message; // Met à jour le message
  notification.className = `notification ${type}`; // Change le type (win, lose, alert)
  notification.style.opacity = 1; // Fait apparaître la notification
  notification.style.visibility = 'visible'; // Fait apparaître la notification

  // Cacher la notification après 3 secondes
  setTimeout(() => {
    notification.style.opacity = 0; // Efface la transparence
    notification.style.visibility = 'hidden'; // Cache la notification
  }, 3000); // 3 secondes
}

// Exemple d'utilisation
function handleGameEnd(isWin) {
  if (isWin) {
    showNotification('Félicitations, vous avez gagné !', 'win');
  } else {
    showNotification('Dommage, vous avez perdu.', 'lose');
  }
}

function showAlert(message) {
  showNotification(message, 'alert'); // Affiche une notification avec type 'alert'
}



function pencilButtonClick() {
  if(!gameOn) return;
  pencilOn = !pencilOn;

  if (pencilOn) {
    document.getElementById("pencil-btn").style.backgroundColor = "#7b9ab4";
  } else {
    document.getElementById("pencil-btn").style.backgroundColor = "#212E53"
    //"#1565c0";
  }

}

function switchInputColor(input,isHint) {
  console.log("avant switch : " + input.classNamen + " value : " + input.value);

  if (pencilOn && !isHint) {
    input.style.color = "red"; // Change le texte en rouge
    input.style.fontSize = "15px";
    input.className = "pencilOn";
  } else{
    input.style.color = "black"; // Change le texte en noir
    input.style.fontSize = "24px";
    input.className = "case";

  }
  console.log("apres switch : " + input.className + " value : " + input.value);;

}
