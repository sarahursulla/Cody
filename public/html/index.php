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
    <title>Cody</title>
  </head>
  <body>
    <form method="post" action="index.php">
      <input type="email" name="email" placeholder="email"/>
      <input type="password" name="password" placeholder="password"/>
      <input type="submit" name="login" value="Connexion"/>
    </form>
  </body>
</html>
