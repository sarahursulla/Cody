<?php

function getQueryParams() {
  $params = array();
  if (isset($_GET["id_matiere"])){
    array_push($params, "id_matiere=" . $_GET["id_matiere"]);
  }
  if (isset($_GET["id_classe"])){
    array_push($params, "id_classe=" . $_GET["id_classe"]);
  }
  if (isset($_GET["id_eleve"])){
    array_push($params, "id_eleve=" . $_GET["id_eleve"]);
  }
  return "?" . join( "&", $params);
}

//==============================================================================
// Login
//==============================================================================
if(isset($_POST["login"])){
  if(empty($_POST["email"]) || empty($_POST["password"])){
    echo "Veuillez rentrer vos identifiants";
  }
  else{
    $db = db_connect();
    $req = $db->prepare("SELECT * FROM Eleves WHERE email = :email");
    $req->execute(array("email" => $_POST["email"]));
    if($data = $req->fetch()){ // Élève ?
      $isPasswordCorrect = password_verify($_POST['password'], $data['password']);
      if($isPasswordCorrect){
        $_SESSION["ID"] = $data["ID_eleve"];
        $_SESSION["PRENOM"] = $data["prenom"];
        $_SESSION["MODE"] = 1;
        $first = first($data["prenom"], $_POST["password"]);
        if($first == true){
          header("Location:../html/changePassword.php");
        }else{
          header("Location:../html/eleves.php");
        }
      }
    }
    else{
      $req = $db->prepare("SELECT * FROM Intervenants WHERE email = :email");
      $req->execute(array("email" => $_POST["email"]));
      if($data = $req->fetch()){ // Intervenant ?
        $isPasswordCorrect = password_verify($_POST['password'], $data['password']);
        if($isPasswordCorrect){
          $_SESSION["ID"] = $data["ID_intervenant"];
          $_SESSION["PRENOM"] = $data["prenom"];
          $_SESSION["MODE"] = 2;
          $first = first($data["prenom"], $_POST["password"]);
          if($first == true){
            header("Location:../html/changePassword.php");
          }else{
            header("Location:../html/intervenants.php");
          }
        }
      }
      else{
        $req = $db->prepare("SELECT * FROM EquipePedagogique WHERE email = :email");
        $req->execute(array("email" => $_POST["email"]));
        if($data = $req->fetch()){ // Équipe pédagogique ?
          $isPasswordCorrect = password_verify($_POST['password'], $data['password']);
          if($isPasswordCorrect){
            $_SESSION["ID"] = $data["ID_equipePedagogique"];
            $_SESSION["PRENOM"] = $data["prenom"];
            $_SESSION["MODE"] = 3;
            $first = first($data["prenom"], $_POST["password"]);
            if($first == true){
              header("Location:../html/changePassword.php");
            }else{
              header("Location:../html/equipePedagogique.php");
            }
          }
        }
        else{
          echo '<script type="text/javascript">
                document.getElementById("error").innerHTML = "cest peesonne";
                </script>';
        }
      }
      $db = null;
    }
  }
}

function first($name, $pass)
{
  $name = '@'.$name;
    if($name == $pass){
      return true;
    }
    return false;
}

//==============================================================================
// Ajouter des notes
//==============================================================================
if(isset($_POST["ajoutNote"])){
  $db = db_connect();
  $req = $db->prepare("INSERT INTO Notes(id_eleve, id_matiere, note, appreciation, note_groupe) VALUES (:id_eleve,:id_matiere,NULL,NULL,NULL)");
  $req->execute(array("id_eleve" => $_POST["id_eleve"],"id_matiere" => $_POST["id_matiere"]));
  $db = null;
}

//==============================================================================
// Modifier des notes
//==============================================================================
if(isset($_POST["changeNote"])){
  $db = db_connect();
  $req = $db->prepare("UPDATE Notes SET note = :note, appreciation = :appreciation, note_groupe = :note_groupe
                      WHERE id_eleve = :id_eleve AND id_matiere = :id_matiere");
  $req->execute(array("id_eleve" => $_POST["ID_eleve"],"id_matiere" => $_POST["id_matiere"],"note" => $_POST["note"],":appreciation" => $_POST["appreciation"],"note_groupe" => $_POST["note_groupe"]));
  $db = null;
}

//==============================================================================
// Supprimer des notes
//==============================================================================
if(isset($_POST["supprimeNote"])){
  $db = db_connect();
  $req = $db->prepare("DELETE FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = :id_matiere");
  $req->execute(array("id_eleve" => $_POST["ID_eleve"],"id_matiere" => $_POST["id_matiere"]));
  $db = null;
}

//==============================================================================
// Écran des élèves
//==============================================================================
function eleve(){
  $db = db_connect();
  $req = $db->prepare("SELECT c.* FROM Classes as c, Eleves as e WHERE c.ID_classe = e.id_classe AND e.ID_eleve = :id_eleve");
  $req->execute(array("id_eleve" => $_SESSION["ID"]));
  $classe = $req->fetch();
  $req = $db->prepare("SELECT AVG(note) as moyenne FROM Notes WHERE id_eleve = :id_eleve");
  $req->execute(array("id_eleve" => $_SESSION["ID"]));
  $data = $req->fetch();
  echo 'Bienvenue '.$_SESSION["PRENOM"].',<br><br>Votre moyenne générale est de '.number_format($data["moyenne"],1).'/20<br><br>';
  $req = $db->prepare("SELECT MAX(N.note) as noteMax, MIN(N.note) as noteMin, N.id_matiere as idMatiere, M.nom,
                      (SELECT note FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as noteEleve,
                      (SELECT appreciation FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as appreciation,
                      (SELECT note_groupe FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as noteGroupe
                      FROM Notes N, Eleves E, Classes C, Matieres M
                      WHERE N.id_eleve = E.ID_eleve
                      AND E.id_classe = C.ID_classe
                      AND C.ID_classe = :id_classe
                      AND N.id_matiere = M.ID_matiere
                      GROUP BY N.id_matiere");
  $req->execute(array("id_eleve" => $_SESSION["ID"],"id_classe" => $classe["ID_classe"]));
  $data = $req->fetchAll();
  echo '<table>';
  echo '<thead><tr>
        <th>Matière</th>
        <th>Note</th>
        <th>Note de groupe</th>
        <th>Max</th>
        <th>Min</th>
        <th>Appréciation</th>
        </tr></thead>';
  echo '<tbody>';
  foreach($data as $row){
    echo '<tr>
          <td>'.$row["nom"].'</td>
          <td>'.$row["noteEleve"].'</td>
          <td>'.number_format($row["noteGroupe"],1).'</td>
          <td>'.$row["noteMax"].'</td>
          <td>'.$row["noteMin"].'</td>
          <td>'.$row["appreciation"].'</td>
          </tr>';
  }
  echo '</tbody>';
}

//==============================================================================
// Écran des intervenants
//==============================================================================
function intervenant(){
  $id_matiere = @$_GET["id_matiere"];
  $id_classe = @$_GET["id_classe"];
  $id_eleve = @$_GET["id_eleve"];

  echo 'Bienvenue '.$_SESSION["PRENOM"].',<br><br>Veuillez selectionner la matière et la classe.<br><br>';
  echo '<form method="get" action="intervenants.php' . getQueryParams() .'">';
  echo '<select name="id_matiere" required>';
  echo '<option selected="true" disabled="disabled">Matière ?</option>';
  $db = db_connect();
  $req = $db->prepare("SELECT * FROM Matieres WHERE id_intervenant = :id_intervenant");
  $req->execute(array("id_intervenant" => $_SESSION["ID"]));
  while($data = $req->fetch()){

    $selected = "";

    if ($id_matiere == $data["ID_matiere"]){
      $selected = 'selected="true"';
    }

    echo '<option '. $selected .' value="'.$data["ID_matiere"].'">'.$data["nom"].'</option>';
  }
  echo '</select>';
  echo '<select name="id_classe" required>';
  echo '<option selected="true" disabled="disabled">Classe ?</option>';
  $req = $db->query("SELECT * FROM Classes");
  while($data = $req->fetch()){
    $selected = "";

    if ($id_classe == $data["ID_classe"]){
      $selected = 'selected="true"';
    }

    echo '<option ' . $selected . ' value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
  }
  echo '</select>';
  echo '<button type="submit">Chercher</button>';
  echo '</form>';

  listing();
}



//==============================================================================
// Écran de l'équipe pédagogique
//==============================================================================
function equipePedagogique(){
  $id_matiere = @$_GET["id_matiere"];
  $id_classe = @$_GET["id_classe"];
  $id_eleve = @$_GET["id_eleve"];


   //iciiiiiiiii deplacement bienvenue
  echo '<p class="bienvenue"> Bienvenue '.$_SESSION["PRENOM"].',<br><br></p>';
  //iciiiiiiiii
  echo '<form class="questions" method="get" action="equipePedagogique.php' . getQueryParams() .  '">';
  echo 'Recherchez par ';
  //iciiiiiiiii
  echo '<select class="choix" name="id_matiere" required>';
  //iciiiiiiiii j'ai supp ?</option>
  echo '<option selected="true" disabled="disabled">Matière';
  $db = db_connect();
   //iciiiiiiiii j'ai ajouté prenom,
  $req = $db->query("SELECT m.*, prenom, i.nom as nomProf FROM Matieres as m, Intervenants as i WHERE m.id_intervenant = i.ID_intervenant");
  while($data = $req->fetch()){
    $selected = "";

    if ($id_matiere == $data["ID_matiere"]){
      $selected = 'selected="true"';
    }
   //iciiiiiiiii j'ai ajouté prenom et changé l'ordre
    echo '<option ' . $selected . ' value="'.$data["ID_matiere"].'">'.$data["prenom"].'  '.$data["nomProf"].' - '.$data["nom"].'</option>';

  }
  echo '</select>';
   //iciiiiiiiii
  echo '<select class="choix" name="id_classe" required>';
   //iciiiiiiiii j'ai supp ?</option>
  echo '<option selected="true" disabled="disabled">Classe';
  $req = $db->query("SELECT * FROM Classes");
  while($data = $req->fetch()){
    $selected = "";

    if ($id_classe == $data["ID_classe"]){
      $selected = 'selected="true"';
    }

    echo '<option ' . $selected . ' value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
  }
  echo '</select>';
    //iciiiiiiiii
  echo '<button class="chercher" type="submit">Chercher</button>';
  echo '<br>Ou';
  echo '</form>';
  echo '<form  class="questions" method="get" action="equipePedagogique.php' . getQueryParams() . '">';
  echo 'Recherchez par ';
   //iciiiiiiiii
  echo '<select  class="choix" name="id_eleve" required>';
     //iciiiiiiiii j'ai supp ?</option>
  echo '<option selected="true" disabled="disabled">Élève';
  $db = db_connect();
  $req = $db->query("SELECT * FROM Eleves");

  while($data = $req->fetch()){
    $selected = "";

    if ($id_eleve == $data["ID_eleve"]){
      $selected = 'selected="true"';
    }

    echo '<option ' . $selected . ' value="'.$data["ID_eleve"].'">'.$data["nom"].' '.$data["prenom"].'</option>';

  }
  echo '</select>';
   //iciiiiiiiii
  echo '<button class="chercher" type="input">Chercher</button>';
  echo '</form>';

  listing();
}

function listing() {
  //============================================================================
  // Affichages des notes par matières
  //============================================================================
  if(isset($_GET["id_matiere"]) && isset($_GET["id_classe"])){
    $id_matiere = $_GET["id_matiere"];
    $id_classe = $_GET["id_classe"];
    // $_SESSION["matiereTEMP"] = $id_matiere;
    // $_SESSION["classeTEMP"] = $id_classe;

    $db = db_connect();
    $req = $db->prepare("SELECT e.*, n.* FROM Eleves as e, Matieres as m, Notes as n
                        WHERE m.ID_matiere = n.id_matiere AND e.ID_eleve = n.id_eleve AND m.ID_matiere = :id_matiere AND e.id_classe = :id_classe
                        ORDER BY e.nom ASC");
    $req->execute(array("id_matiere" => $id_matiere, "id_classe" => $id_classe));
    $data = $req->fetchAll();

    echo '<table>';
    echo '<thead><tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Note</th>
          <th>Note de groupe</th>
          <th>Appréciation</th>
          <th>Modifier</th>
          <th>Supprimer</th>
          </tr>
          </thead>';
    echo '<tbody>';
    foreach($data as $row){
      echo '<form method="post" action="">';
      echo '<tr>';
      echo '<input type="hidden" name="ID_eleve" value="'.$row["ID_eleve"].'"/>
            <input type="hidden" name="id_matiere" value="'.$row["id_matiere"].'"/>
            <td>'.$row["nom"].'</td>
            <td>'.$row["prenom"].'</td>
            <td><input type="number" name="note" step="0.1" value="'.$row["note"].'"/></td>
            <td><input type="number" name="note_groupe" step="0.1" value="'.$row["note_groupe"].'"/></td>
            <td><input type="text" name="appreciation" value="'.$row["appreciation"].'"/></td>
            <td><input type="submit" name="changeNote" value="Modifier"/></td>
            <td><input type="submit" name="supprimeNote" value="Supprimer"/></td>';
      echo '</tr>';
      echo '</form>';
    }
    echo '</tbody>';
    echo '</table>';

    $req = $db->prepare("SELECT * FROM Eleves WHERE id_classe = :id_classe
                        AND id_eleve NOT IN (SELECT id_eleve FROM Notes n WHERE id_matiere = :id_matiere)
                        ORDER BY nom ASC");
    $req->execute(array("id_classe" => $id_classe,"id_matiere" => $id_matiere));
    $data = $req->fetchAll();
    $nbdata = count($data);
    if($nbdata > 0){
      echo '<form method="post" action="">';
      echo '<select name="id_eleve" required>';
      echo '<option selected="true" disabled="disabled">Élève ?</option>';
      foreach($data as $row){
        echo '<option value="'.$row["ID_eleve"].'">'.$row["nom"].' '.$row["prenom"].'</option>';
      }
      echo '<input type="hidden" name="id_matiere" value="'.$id_matiere.'"/>';
      echo '</select>';
      echo '<input type="submit" name="ajoutNote" value="Ajouter"/>';
      echo '</form>';
    }
    $db = null;
  }

  //============================================================================
  // Affichages des notes par élèves
  //============================================================================
  if(isset($_GET["id_eleve"])){
    $id_eleve =  $_GET["id_eleve"];

    $db = db_connect();
    $req = $db->query("SELECT * FROM Eleves");
    $data = $req->fetch();
    $req = $db->prepare("SELECT MAX(N.note) as noteMax, MIN(N.note) as noteMin, N.id_matiere as idMatiere, M.nom,
                        (SELECT note FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as noteEleve,
                        (SELECT appreciation FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as appreciation,
                        (SELECT note_groupe FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as noteGroupe,
                        (SELECT ID_eleve FROM Eleves WHERE id_eleve = :id_eleve) as ID_eleve
                        FROM Notes N, Eleves E, Classes C, Matieres M
                        WHERE N.id_eleve = E.ID_eleve
                        AND E.id_classe = C.ID_classe
                        AND C.ID_classe = :id_classe
                        AND N.id_matiere = M.ID_matiere
                        GROUP BY N.id_matiere");
    $req->execute(array("id_eleve" => $id_eleve,"id_classe" => $data["id_classe"]));
    $data = $req->fetchAll();
    echo '<table>
            <thead><tr>
              <th>Matière</th>
              <th>Note</th>
              <th>Note de groupe</th>
              <th>Max</th>
              <th>Min</th>
              <th>Appréciation</th>
              <th>Modifier</th>
              <th>Supprimer</th>
            </tr></thead>';
    echo '<tbody>';
    foreach($data as $row){
      echo '<form method="post">';
      echo '<tr>';
      echo '<input type="hidden" name="ID_eleve" value="'.$row["ID_eleve"].'"/>
            <input type="hidden" name="id_matiere" value="'.$row["idMatiere"].'"/>
            <td>'.$row["nom"].'</td>
            <td><input type="number" name="note" step="0.1" value="'.$row["noteEleve"].'"/></td>
            <td><input type="number" name="note_groupe" step="0.1" value="'.number_format($row["noteGroupe"],1).'"/></td>
            <td>'.number_format($row["noteMax"],1).'</td>
            <td>'.number_format($row["noteMin"],1).'</td>
            <td><input type="text" name="appreciation" value="'.$row["appreciation"].'"/></td>';
      echo '<td><input type="submit" name="changeNote" value="Modifier"/></td>';
      echo '<td><input type="submit" name="supprimeNote" value="Supprimer"/></td><tr>';
      echo '</tr>';
      echo '</form>';
    }
    echo '</tbody>';
  }
}

//==============================================================================
// Gestion mots de passe
//==============================================================================
if(isset($_POST["changermdp"])){
  switch ($_SESSION["MODE"]) {
    case 1:
      $table = "Eleves";
      $idtable = "ID_eleve";
      break;
    case 2:
      $table = "Intervenants";
      $idtable = "ID_intervenant";
      break;
    case 3:
      $table = "EquipePedagogique";
      $idtable = "ID_membre";
      break;
  }
  $default = '@'.$_SESSION["PRENOM"];
  $hache = password_hash($_POST["pass1"], PASSWORD_DEFAULT);
  if($_POST["pass1"] == $_POST["pass2"] && $_POST["pass1"] != $default){
    $db = db_connect();
    $req = $db->prepare("UPDATE $table SET password = :password WHERE $idtable = :idtable2");
    $req->execute(array("password" => $hache,"idtable2" => $_SESSION["ID"]));
    $db = null;
    switch ($_SESSION["MODE"]) {
      case 1:
        header("Location:../html/eleves.php");
        break;
      case 2:
        header("Location:../html/intervenants.php");
        break;
      case 3:
        header("Location:../html/equipePedagogique.php");
        break;
    }
  }
  echo 'nope';
}

/*function hache(){
  $db = db_connect();
  $req = $db->query("SELECT * FROM EquipePedagogique");
  $data = $req->fetchAll();
  foreach($data as $row){
    $newpass = password_hash($row["password"], PASSWORD_DEFAULT);
    $req = $db->prepare("UPDATE EquipePedagogique SET password = :password WHERE ID_membre = :id");
    $req ->execute(array("password" => $newpass,"id" => $row["ID_membre"]));
  }
}*/
?>
