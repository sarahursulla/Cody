<?php
  session_start();

  include("../php/db_connect.inc.php");
  include("../js/script.php");
?>

<!DOCTYPE <!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="main.js"></script>
    <title>Cody</title>
  </head>
  <body>
    <form method="post" action="index.php">
      <tr>
        <td><input type="email" name="email" placeholder="email"/></td>
        <td><input type="password" name="password" placeholder="password"/></td>
        <td><input type="submit" name="login"/></td>
      </tr>
    </form>

    <!--<table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Montant</th>
          <th>Type</th>
          <th>Devise</th>
          <th>Valider</th>
          <th>Supprimer</th>
        </tr>
      </thead>
      <tbody id="table-body">
        <form method="post" action="index.php">
          <tr>
            <td><input type="text" name="name" placeholder="ex : Credit du Nord"/></td>
            <td><input type="number" name="fund" step="0.01" placeholder="ex : 500,00"/></td>
            <td>
              <select name="type">
                <option disabled selected value="-1">Choissisez un type de compte</option>
                <option value="courant">Courant</option>
                <option value="epargne">Épargne</option>
                <option value="joint">Compte joint</option>
              </select>
            </td>
            <td>
              <select name="currency">
                <option disabled selected value="-1">Choisissez votre devise</option>
                <option value="EUR">EUR</option>
                <option value="USD">USD</option>
              </select>
            </td>
            <td><input type="submit" name="createAccount"/></td>
            <td><input type="reset"/></td>
          </tr>
        </form>
        <?php listAccount();?>
      </tbody>
    </table>-->
  </body>
</html>
