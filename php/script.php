<?php
include(__DIR__ . "/utils/students.php");
include(__DIR__ . "/views/table-students.php");

//==============================================================================
// Login
//==============================================================================
if(isset($_POST["login"])){
  $db = db_connect();
  $req = $db->prepare("SELECT * FROM Eleves WHERE email = :email AND password = :password");
  $req->execute(array("email" => $_POST["email"],"password" => $_POST["password"]));
  if($data = $req->fetch()){ // Élève ?
    $_SESSION["ID"] = $data["ID_eleve"];
    $_SESSION["PRENOM"] = $data["prenom"];
    header("Location:./html/eleves.php");
  }
  else{
    $req = $db->prepare("SELECT * FROM Intervenants WHERE email = :email AND password = :password");
    $req->execute(array("email" => $_POST["email"],"password" => $_POST["password"]));
    if($data = $req->fetch()){ // Intervenant ?
      $_SESSION["ID"] = $data["ID_intervenant"];
      $_SESSION["PRENOM"] = $data["prenom"];
      header("Location:./html/intervenants.php");
    }
    else{
      $req = $db->prepare("SELECT * FROM EquipePedagogique WHERE email = :email AND password = :password");
      $req->execute(array("email" => $_POST["email"],"password" => $_POST["password"]));
      if($data = $req->fetch()){ // Équipe pédagogique ?
        $_SESSION["ID"] = $data["ID_equipePedagogique"];
        $_SESSION["PRENOM"] = $data["prenom"];
        header("Location:./html/equipePedagogique.php");
      }
      else{ // Erreur
        echo "Erreur";
      }
    }
  }
  $db = null;
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
  echo 'Bienvenue '.$_SESSION["PRENOM"].', votre moyenne générale est de '.number_format($data["moyenne"],1).'/20<br>';
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
  echo 'Bienvenue '.$_SESSION["PRENOM"];
  echo '<form method="get" action="intervenants.php">';
  echo '<select name="id_matiere">';
  echo '<option selected="true" disabled="disabled">Matière ?</option>';
  $db = db_connect();
  $req = $db->prepare("SELECT * FROM Matieres WHERE id_intervenant = :id_intervenant");
  $req->execute(array("id_intervenant" => $_SESSION["ID"]));
  while($data = $req->fetch()){
    if($_SESSION["matiereTEMP"] == $data["ID_matiere"]){
      echo '<option selected="true" value="'.$data["ID_matiere"].'">'.$data["nom"].'</option>';
    }
    else{
      echo '<option value="'.$data["ID_matiere"].'">'.$data["nom"].'</option>';
    }
  }
  echo '</select>';
  echo '<select name="id_classe">';
  echo '<option selected="true" disabled="disabled">Classe ?</option>';
  $req = $db->query("SELECT * FROM Classes");
  while($data = $req->fetch()){
    if($_SESSION["classeTEMP"] == $data["ID_classe"]){
      echo '<option selected="true" value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
    }
    else{
      echo '<option value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
    }
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
  echo 'Bienvenue '.$_SESSION["PRENOM"];
  echo '<form method="get" action="equipePedagogique.php">';
  echo '<select name="id_matiere">';
  echo '<option selected="true" disabled="disabled">Matière ?</option>';
  $db = db_connect();
  $req = $db->query("SELECT m.*, i.nom as nomProf FROM Matieres as m, Intervenants as i WHERE m.id_intervenant = i.ID_intervenant");
  while($data = $req->fetch()){
    if($_SESSION["matiereTEMP"] == $data["ID_matiere"]){
      echo '<option selected="true" value="'.$data["ID_matiere"].'">'.$data["nomProf"].' - '.$data["nom"].'</option>';
    }
    else{
      echo '<option value="'.$data["ID_matiere"].'">'.$data["nomProf"].' - '.$data["nom"].'</option>';
    }
  }
  echo '</select>';
  echo '<select name="id_classe">';
  echo '<option selected="true" disabled="disabled">Classe ?</option>';
  $req = $db->query("SELECT * FROM Classes");
  while($data = $req->fetch()){
    if($_SESSION["classeTEMP"] == $data["ID_classe"]){
      echo '<option selected="true" value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
    }
    else{
      echo '<option value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
    }
  }
  echo '</select>';
  echo '<input type="submit" name="chercherMatiere" value="Chercher"/>';
  echo '</form>';
  echo '<form method="post" action="equipePedagogique.php">';
  echo '<select name="id_eleve">';
  echo '<option selected="true" disabled="disabled">Élève ?</option>';
  $db = db_connect();
  $req = $db->query("SELECT * FROM Eleves");
  while($data = $req->fetch()){
    if($_SESSION["eleveTEMP"] == $data["ID_eleve"]){
      echo '<option selected="true" value="'.$data["ID_eleve"].'">'.$data["nom"].' '.$data["prenom"].'</option>';
    }
    else{
      echo '<option value="'.$data["ID_eleve"].'">'.$data["nom"].' '.$data["prenom"].'</option>';
    }
  }
  echo '</select>';
  echo '<input type="submit" name="chercherEleve" value="Chercher"/>';
  echo '</form>';

  listing();
}

function listing() {
  //============================================================================
  // Affichages des notes par matières
  //============================================================================
  if(isset($_GET["id_matiere"]) && isset($_GET["id_classe"])){
    $id_matiere =  $_GET["id_matiere"];
    $id_classe =  $_GET["id_classe"];
    $_SESSION["matiereTEMP"] = $id_matiere;
    $_SESSION["classeTEMP"] = $id_classe;

    $db = db_connect();
    $data = findStudents($db, $id_matiere, $id_classe);

    tableStudents($data, $id_matiere, $id_classe);

    $req = $db->prepare("SELECT * FROM Eleves WHERE id_classe = :id_classe
                        AND id_eleve NOT IN (SELECT id_eleve FROM Notes n WHERE id_matiere = :id_matiere)
                        ORDER BY nom ASC");
    $req->execute(array("id_classe" => $id_classe,"id_matiere" => $id_matiere));
    $data = $req->fetchAll();
    $nbdata = count($data);
    if($nbdata > 0){
      echo '<form method="post" action="">';
      echo '<select name="id_eleve">';
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
  if(isset($_POST["chercherEleve"])){
    $_SESSION["eleveTEMP"] = $_POST["id_eleve"];
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
    $req->execute(array("id_eleve" => $_POST["id_eleve"],"id_classe" => $data["id_classe"]));
    $data = $req->fetchAll();
    echo '<table>';
    echo '<thead><tr>
          <th></th>
          <th></th>
          <th>Matière</th>
          <th>Note</th>
          <th>Note de groupe</th>
          <th>Max</th>
          <th>Min</th>
          <th>Appréciation</th>
          </tr></thead>';
    echo '<tbody>';
    foreach($data as $row){
      echo '<form method="post">';
      echo '<tr>';
      echo '<td><input type="hidden" name="ID_eleve" value="'.$row["ID_eleve"].'"/></td>
            <td><input type="hidden" name="id_matiere" value="'.$row["idMatiere"].'"/></td>
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

?>
