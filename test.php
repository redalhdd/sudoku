<?php
include 'db_connect.php';
if (isset($_GET['username'])) {
  $currentUsername = $_GET['username'];
  echo "<script>var currentUsername = '" . htmlspecialchars($currentUsername, ENT_QUOTES, 'UTF-8') . "';</script>";
} else {
  echo "<script>console.error('Username is not defined');</script>";
}

// Fetch data and display in table
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="css/style.css">
  <link href="css/profile.css" rel="stylesheet" type="text/css">
  <script src="js/script.js"></script>
  <title>Sudoku</title>
</head>
<body>
    <div id="notification" class="notification">This is a notification!</div>
    <nav class="navtop">
        <div>
            <h1>SUDOKU</h1>
            <a id="profile-link"><i class="fas fa-user-circle"></i>Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </nav>
    

    <!-- Modal Structure -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Profile Details</h2>
            <table>
                <tr>
                    <td>Username:</td>
                    <td><?= htmlspecialchars($_SESSION['name'], ENT_QUOTES) ?></td>
                </tr>
                <tr>
                    <td>Score:</td>
                    <td><?= htmlspecialchars($_SESSION['score'], ENT_QUOTES) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <script src="js/profile.js"></script>
        <div id="dialog" class="dialog">
          <div id="dialog-box" class="dialog-content">
            <div class="dialog-header">Nouvelle Partie</div>
      
            <div class="dialog-body">
              <p>Choisir la difficulté pour commencer.</p>
              <ul>
                <li class="radio-option">
                  <label for="very-easy">
                    <input id="very-easy" value="very easy" type="radio" name="difficulty"> Très facile
                  </label>
                </li>
                <li class="radio-option">
                  <label for="easy">
                    <input id="easy" value="easy" type="radio" name="difficulty"> Facile
                  </label>
                </li>
                <li class="radio-option">
                  <label for="normal">
                    <input id="normal" value="normal" type="radio" name="difficulty" checked="checked"> Normal
                  </label>
                </li>
                <li class="radio-option">
                  <label for="hard">
                    <input id="hard" value="hard" type="radio" name="difficulty"> Difficile
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
                class="button dialog-btn vertical-adjust">Annuler</button>
            </div>
          </div>
        </div>
      
      
        <!-- <center>
          <h4 style="margin-top: 50px; font-size: 50px;">SUDOKU</h4>

        </center> -->
        <div class="body" id="sudoku">
          <div class="card first">
            <ul class="game-status">
              <li>
                <div id="timer-label" class="timer" style="padding:0;"><button onclick="showDialogClick('dialog');"
                    class="button  my-button" id="new-game">Nouvelle partie</button>
                </div>
              </li>
      
              <li>
                <div class="vertical-adjust">
                  <span>
                    <h3>CLASSEMENT</h3>
                  </span>
                </div>
      
      
                <div class="score-table">
                  <table id="leaderboard">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Pseudo</th>
                        <th>Score</th>
                      </tr>
                    </thead>
                    <tbody>
                     
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
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
              <tr>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
              <tr>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
              <tr>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
              <tr>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
              <tr>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
              <tr>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
              <tr>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
              <tr>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)"  disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
      
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
                <td>
                  <input class="case" type="text" maxlength="1" onchange="checkInput(this)" disabled />
                </td>
              </tr>
      
            </table>
          <!--***********     FIN SUDOKU TABLE     ********-->
      
      
      
            <!--***********     LIGNE DE CHIFFRE     ********-->
            <div style="display: flex; flex-direction: row; align-items: center; width: 100%; justify-content: space-between;">
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="1" onclick="selectNumber(this)">1</button>
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="2" onclick="selectNumber(this)">2</button>
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="3" onclick="selectNumber(this)">3</button>
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="4" onclick="selectNumber(this)">4</button>
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="5" onclick="selectNumber(this)">5</button>
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="6" onclick="selectNumber(this)">6</button>
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="7" onclick="selectNumber(this)">7</button>
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="8" onclick="selectNumber(this)">8</button>
              <button class="button number-button"
                style="margin: 5px; width: 40px; height: 40px; background-color: white; border: 1px solid #212E53; font-weight: bold; color: #212E53; font-size: 24px;"
                value="9" onclick="selectNumber(this)">9</button>
            </div>
            <!--***********    FIN LIGNE DE CHIFFRE      ********-->
      
            <!--***********    LIGNE DE COMMANDES      ********-->
            <div
              style="display: flex; flex-direction: row; align-items: center; width: 100%; justify-content: space-between;">
              <button class="button my-button" style="margin: 5px; width: fit-content; height: fit-content;" onclick="hintButtonClick()"><img
                  src="images/hint.png" style="height: 30px;" ></button>
              <button onclick="pauseGameButtonClick()" id="pause-btn" class="button my-button"
                style="margin: 5px; width: fit-content; height: fit-content;"><img id="pause-img" src="images/pause.webp"
                  style="height: 50px;"></button>
              <button class="button my-button" id="pencil-btn" style="margin: 5px; width: fit-content; height: fit-content;" onclick="pencilButtonClick()"><img
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
      
                <div style="width: 250px;  padding: 10%; border-radius: 5px;">
                  <h2>Règles du jeu</h2>
                  <ol>
                    <li><strong>Objectif du jeu</strong> : Remplir la grille avec des chiffres de manière à respecter les règles suivantes.</li>
                    <li><strong>Grille standard</strong> : Un Sudoku classique est constitué d'une grille de 9x9 cases, divisée en 9 régions de 3x3 cases.</li>
                    <li><strong>Règles de placement</strong> :
                        <ul>
                            <li>Chaque chiffre de 1 à 9 doit apparaître <strong>une seule fois</strong> dans chaque ligne.</li>
                            <li>Chaque chiffre de 1 à 9 doit apparaître <strong>une seule fois</strong> dans chaque colonne.</li>
                            <li>Chaque chiffre de 1 à 9 doit apparaître <strong>une seule fois</strong> dans chaque région de 3x3.</li>
                        </ul>
                    </li>
                    <li><strong>Score et Classement</strong> : 
                      <ul>
                        <li>Moins de temps et moins d'indices = meilleur score.</li>
                        <li>Le classement est basé sur le score total des joueurs.</li>
                   </ul>
                    </li>
                    <li><strong>Utilisation des indices</strong> <ul>
                      <li>Vous pouvez utiliser des indices si vous bloquez sur une cellule.</li>
                      <li>Un indice vous montrera un chiffre correct à placer.</li>
                      <li>Utilisez judicieusement les indices pour maximiser vos chances de réussir.</li>
                   </ul></li>
                   <li><strong>Niveaux de difficulté</strong> <ul>
                    <li>Facile : Plus de chiffres pré-remplis, idéal pour les débutants.</li>
        <li>Intermédiaire : Moins de chiffres pré-remplis, nécessite plus de réflexion et d’analyse.</li>
        <li>Difficile : Très peu de chiffres pré-remplis, nécessitant une logique et une concentration accrues.</li>
   </ul></li>
                    <li><strong>But final</strong> : Compléter toutes les cases de la grille en respectant ces règles.</li>
                </ol>
                </div>
                
              </li>
            </ul>
      
      
          </div>
        </div>
      
        <div class="footer vertical-adjust">
         
  <script>

    // Gestionnaire pour sélectionner un input actif
    let activeInput = null;
    document.querySelectorAll('.case').forEach(input => {
      input.addEventListener('click', function () {
        activeInput = this;
        //console.log("Champ actif :", activeInput);
      });
    });

    // Gestionnaire pour les boutons
    function selectNumber(button) {
        if (selectedNumber != null) {
        selectedNumber.style.backgroundColor = "white";
        selectedNumber.style.color = "#212E53";
      }
      button.style.backgroundColor = "#212E53";
      button.style.color = "white";
      selectedNumber = button;
      
      if (activeInput) {
        activeInput.value = button.value;
        //console.log("Valeur insérée :", button.value);
        activeInput.dispatchEvent(new Event('change')); // Déclenche "onchange" manuellement
      } else {
        showAlert("Veuillez d'abord sélectionner un champ.");
      }
    }
  </script>
</body>
</html>