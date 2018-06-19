<?php
  session_start();
  include("../php/db_connect.inc.php");
  include("../php/script.php");
?>

<!DOCTYPE <!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="main.js"></script>
    <title>Cody - Équipe pédagogique</title>
  </head>
  <body>
    <a href="../php/logout.php">Déconnexion</a>
    <?php EquipePedagogique();?>
    <script src="../js/formulaire.js"></script>
  </body>
