<?php
include 'db_connect.php';

// Fetch all users and scores in descending order by score
$stmt = $con->prepare('SELECT id, username, score FROM accounts ORDER BY score DESC');
$stmt->bind_result($id, $username, $score);
$stmt->execute();

// Fetch data and display in table
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Sudoku</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
</head>

<body>

<div id="notification" class="notification">Veuillez d'abord sélectionner une case.</div>

  <div id="dialog" class="dialog">
    <div id="dialog-box" class="dialog-content">
      <div class="dialog-header">New game</div>

      <div class="dialog-body">
        <p>Select game difficulty to get started.</p>
        <ul>
          <li class="radio-option">
            <label for="very-easy">
              <input id="very-easy" value="very easy" type="radio" name="difficulty"> Very easy
            </label>
          </li>
          <li class="radio-option">
            <label for="easy">
              <input id="easy" value="easy" type="radio" name="difficulty"> Easy
            </label>
          </li>
          <li class="radio-option">
            <label for="normal">
              <input id="normal" value="normal" type="radio" name="difficulty" checked="checked"> Normal
            </label>
          </li>
          <li class="radio-option">
            <label for="hard">
              <input id="hard" value="hard" type="radio" name="difficulty"> Hard
            </label>
          </li>
          <li class="radio-option">
            <label for="very-hard">
              <input id="very-hard" value="expert" type="radio" name="difficulty"> Expert
            </label>
          </li>
        </ul>
      </div>

      <div class="dialog-footer">
        <button onclick="startGameButtonClick();" ripple-color="#003c8f"
          class="button dialog-btn vertical-adjust">OK</button>
        <button onclick="hideDialogButtonClick('dialog');" ripple-color="#202020"
          class="button dialog-btn vertical-adjust">Cancel</button>
      </div>
    </div>
  </div>


  <center>
    <h4 style="margin-top: 50px; font-size: 50px;">SUDOKU</h4>
  </center>
  <div class="body" id="sudoku">
    <div class="card first">
      <ul class="game-status">
        <li>
          <div id="timer-label" class="timer" style="padding:0;"><button onclick="showDialogClick('dialog');"
              class="button  my-button">New Game</button>
          </div>
        </li>

        <li>
          <div class="vertical-adjust">
            <span>
              <h3>CLASSEMENT</h3>
            </span>
          </div>


          <div class="score-table">
            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Pseudo</th>
                  <th>Score</th>
                </tr>
              </thead>
              <tbody>
              <?php
            $rank = 1; // Initialize rank counter
            while ($stmt->fetch()) {
                echo "<tr>
                        <td>{$rank}</td>
                        <td>{$username}</td>
                        <td>{$score}</td>
                      </tr>";
                $rank++; // Increment the rank
            }
            ?>
              </tbody>
            </table>
          </div>

  
    </div>
    <div class="card game">
      <div style="display: flex; flex-direction: row; justify-content: space-between;">
        <div id="game-level" style="padding-bottom: 5px;"></div>
        <div id="game-mistakes" style="padding-bottom: 5px;"></div>
      </div>




    <!--************    SUDOKU TABLE     **************-->
      <table id="puzzle-grid">
        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

        <tr>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>

          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
          <td>
            <input class="case" type="text" maxlength="1"   onchange="checkInput(this)" onclick="handleInputClick(this)" disabled />
          </td>
        </tr>

      </table>
    <!--***********     FIN SUDOKU TABLE     ********-->

   

      <!--***********     LIGNE DE CHIFFRE     ********-->
      <div style="display: flex; flex-direction: row; align-items: center; width: 100%; justify-content: space-between;">
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="1" onclick="selectNumber(this)">1</button>
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="2" onclick="selectNumber(this)">2</button>
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="3" onclick="selectNumber(this)">3</button>
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="4" onclick="selectNumber(this)">4</button>
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="5" onclick="selectNumber(this)">5</button>
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="6" onclick="selectNumber(this)">6</button>
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="7" onclick="selectNumber(this)">7</button>
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="8" onclick="selectNumber(this)">8</button>
        <button class="button number-button"
          style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #1565c0; font-weight: bold; color: #1565c0; font-size: 24px;"
          value="9" onclick="selectNumber(this)">9</button>
      </div>
      <!--***********    FIN LIGNE DE CHIFFRE      ********-->

      <!--***********    LIGNE DE COMMANDES      ********-->
      <div
        style="display: flex; flex-direction: row; align-items: center; width: 100%; justify-content: space-between;">
        <button class="button my-button" style="margin: 5px; width: fit-content; height: fit-content;"><img
            src="images/hint.png" style="height: 30px;"></button>
        <button onclick="pauseGameButtonClick()" id="pause-btn" class="button my-button"
          style="margin: 5px; width: fit-content; height: fit-content;"><img id="pause-img" src="images/pause.webp"
            style="height: 50px;"></button>
        <button class="button my-button" style="margin: 5px; width: fit-content; height: fit-content;"><img
            src="images/pencil.png" style="height: 30px;"></button>
      </div>
      <!--***********   FIN LIGNE DE COMMANDES      ********-->

    </div>
    <div class="card status">
      <ul class="game-status">
        <li>
      
          <div id="timer" class="timer">00:00</div>
        </li>

      
        <li>

          <div style="width: 250px;">
            <h2>Règles du jeu</h2>
            <ol>
              <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
              <li>Praesent sit amet arcu sodales, vehicula nulla pharetra, faucibus purus.</li>
              <li>Aliquam tristique bibendum est ultricies suscipit.</li>
              <li>Nulla facilisi.</li>
              <li>Morbi ornare tempor hendrerit.</li>
              <li>Quisque convallis sem velit, quis finibus leo pretium vel.</li>
              <li>Etiam a magna eu nisi iaculis aliquet.</li>
              <li>Cras sagittis mauris et quam pharetra pretium.</li>
              <li>Vivamus cursus tellus massa, vel dapibus purus mollis vel.</li>
              <li>Donec lobortis euismod dolor a pulvinar.</li>
              <li>Donec condimentum rutrum arcu, nec molestie dui commodo non.</li>
              <li>Mauris vel nunc maximus, gravida nisi vulputate, sodales dolor.</li>
              <li>Nunc mollis tempor dolor, sed aliquet eros faucibus sit amet.</li>
            </ol>
          </div>
          
        </li>
      </ul>


    </div>
  </div>

  <div class="footer vertical-adjust">
   
</body>

</html>