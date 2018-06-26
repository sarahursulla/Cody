<?php
function entete($mode) {
  if ($mode >= 1 && $mode <= 3) { // Si quelqu'un est connecté
    echo '<li><a href="signin.php">Espace personnel de '.$_SESSION["PRENOM"].'</a></li>';
    echo '<li><a href="../php/logout.php">DÉCONNEXION</a></li>';
  } else {
    echo '<li><a class="btn" href="signin.php">CONNEXION</a></li>';
  }
}
?>
