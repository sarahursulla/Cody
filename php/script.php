<?php
//==============================================================================
// Login
//==============================================================================
if (isset($_POST["login"])) {
  if (empty($_POST["email"]) || empty($_POST["password"])) {
    //VEUILLEZ RENTRER VOS IDENTIFIANTS
  }else {
    $db = db_connect();
    $req = $db->prepare("SELECT * FROM Eleves WHERE email = :email");
    $req->execute(array("email" => $_POST["email"]));
    if ($data = $req->fetch()) { // Élève ?
      MDP("ID_eleve", 4, 1, $data, $_POST);
    }else {
      $req = $db->prepare("SELECT * FROM Intervenants WHERE email = :email");
      $req->execute(array("email" => $_POST["email"]));
      if ($data = $req->fetch()) { // Intervenant ?
        MDP("ID_intervenant", 5, 2, $data, $_POST);
      }else {
        $req = $db->prepare("SELECT * FROM EquipePedagogique WHERE email = :email");
        $req->execute(array("email" => $_POST["email"]));
        if ($data = $req->fetch()) { // Équipe pédagogique ?
          MDP("ID_membre", 6, 3, $data, $_POST);
        }else {
          //LOGIN INCORRECT
        }
      }
      $db = null;
    }
  }
}

function MDP($id, $mode2, $mode, $data, $post) {
  $position = strpos($data["password"], "@");
  if ($position === 0 && $post["password"] == $data["password"]) {
    $_SESSION["ID"] = $data[$id];
    $_SESSION["PRENOM"] = $data["prenom"];
    $_SESSION["MODE"] = $mode2;
    header("Location:../html/changePassword.php");
  }else {
    $isPasswordCorrect = password_verify($post["password"], $data["password"]);
    if ($isPasswordCorrect) {
      $_SESSION["ID"] = $data[$id];
      $_SESSION["PRENOM"] = $data["prenom"];
      $_SESSION["MODE"] = $mode;
      header("Location:../html/equipePedagogique.php");
    }
  }
}

//==============================================================================
// Ajouter des notes
//==============================================================================
if (isset($_POST["ajoutNote"])) {
  $db = db_connect();
  $req = $db->prepare("INSERT INTO Notes(id_eleve, id_matiere, note, appreciation, note_groupe) VALUES (:id_eleve, :id_matiere, NULL, NULL, NULL)");
  $req->execute(array("id_eleve" => $_POST["id_eleve"], "id_matiere" => $_POST["id_matiere"]));
  $db = null;
}

//==============================================================================
// Modifier des notes
//==============================================================================
if (isset($_POST["changeNote"])) {
  $db = db_connect();
  $req = $db->prepare("UPDATE Notes SET note = :note, appreciation = :appreciation, note_groupe = :note_groupe
                      WHERE id_eleve = :id_eleve AND id_matiere = :id_matiere");
  $req->execute(array("id_eleve" => $_POST["ID_eleve"], "id_matiere" => $_POST["id_matiere"], "note" => $_POST["note"], ":appreciation" => $_POST["appreciation"], "note_groupe" => $_POST["note_groupe"]));
  $db = null;
}

//==============================================================================
// Supprimer des notes
//==============================================================================
if (isset($_POST["supprimeNote"])) {
  $db = db_connect();
  $req = $db->prepare("DELETE FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = :id_matiere");
  $req->execute(array("id_eleve" => $_POST["ID_eleve"], "id_matiere" => $_POST["id_matiere"]));
  $db = null;
}

//==============================================================================
// Écran des élèves
//==============================================================================
function eleve() {
  if ($_SESSION["MODE"] == 1) {
    $db = db_connect();
    $req = $db->prepare("SELECT C.* FROM Classes C, Eleves E WHERE C.ID_classe = E.id_classe AND E.ID_eleve = :id_eleve");
    $req->execute(array("id_eleve" => $_SESSION["ID"]));
    $classe = $req->fetch();
    $req = $db->prepare("SELECT AVG(note) as moyenne FROM Notes WHERE id_eleve = :id_eleve");
    $req->execute(array("id_eleve" => $_SESSION["ID"]));
    $data = $req->fetch();
    echo '<p class="bienvenue">Bienvenue '.$_SESSION["PRENOM"].',<br><br>Votre moyenne générale est de '.number_format($data["moyenne"], 1).'/20<br><br></p>';
    $req = $db->prepare("SELECT MAX(N.note) as noteMax, MIN(N.note) as noteMin, AVG(N.note) as moyenne, N.id_matiere as idMatiere, M.nom,
                        (SELECT note FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as noteEleve,
                        (SELECT appreciation FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as appreciation,
                        (SELECT note_groupe FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as noteGroupe
                        FROM Notes N, Eleves E, Classes C, Matieres M
                        WHERE N.id_eleve = E.ID_eleve
                        AND E.id_classe = C.ID_classe
                        AND C.ID_classe = :id_classe
                        AND N.id_matiere = M.ID_matiere
                        GROUP BY N.id_matiere");
    $req->execute(array("id_eleve" => $_SESSION["ID"], "id_classe" => $classe["ID_classe"]));
    $data = $req->fetchAll();
    echo '<table>';
    echo '<thead><tr>
          <th>Matière</th>
          <th>Note</th>
          <th>Note de groupe</th>
          <th>Moyenne de la classe</th>
          <th>Max</th>
          <th>Min</th>
          <th>Appréciation</th>
          </tr></thead>';
    echo '<tbody>';
    foreach ($data as $row) {
      echo '<tr>
            <td>'.$row["nom"].'</td>
            <td>'.$row["noteEleve"].'</td>
            <td>'.number_format($row["noteGroupe"], 1).'</td>
            <td>'.number_format($row["moyenne"], 1).'</td>
            <td>'.$row["noteMax"].'</td>
            <td>'.$row["noteMin"].'</td>
            <td>'.$row["appreciation"].'</td>
            </tr>';
    }
    echo '</tbody>';
    echo '</table>';
  } else {
    header("Location:../html/signin.php");
  }
}

//==============================================================================
// Écran des intervenants
//==============================================================================
function intervenant() {
  if ($_SESSION["MODE"] == 2) {
    $id_matiere = @$_GET["id_matiere"];
    $id_classe = @$_GET["id_classe"];
    $id_eleve = @$_GET["id_eleve"];
    echo '<p class="bienvenue">Bienvenue '.$_SESSION["PRENOM"].',</p>';
    echo '<form class="questions" method="get" action="intervenants.php'.getQueryParams().'">';
    echo 'Veuillez sélectionner la matière et la classe';
    echo '<select class="choix" name="id_matiere" required>';
    echo '<option selected="true" disabled="disabled">Matière</option>';
    $db = db_connect();
    $req = $db->prepare("SELECT * FROM Matieres WHERE id_intervenant = :id_intervenant");
    $req->execute(array("id_intervenant" => $_SESSION["ID"]));
    while ($data = $req->fetch()) {
      $selected = "";
      if ($id_matiere == $data["ID_matiere"]) {
        $selected = 'selected="true"';
      }
      echo '<option '.$selected.' value="'.$data["ID_matiere"].'">'.$data["nom"].'</option>';
    }
    echo '</select>';
    echo 'et';
    echo '<select class="choix" name="id_classe" required>';
    echo '<option selected="true" disabled="disabled">Classe</option>';
    $req = $db->query("SELECT * FROM Classes");
    while ($data = $req->fetch()) {
      $selected = "";
      if ($id_classe == $data["ID_classe"]) {
        $selected = 'selected="true"';
      }
      echo '<option '.$selected.' value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
    }
    echo '</select>';
    echo '<button class="chercher" type="submit">Afficher</button>';
    echo '</form>';
    listing();
  } else {
    header("Location:../html/signin.php");
  }
}

//==============================================================================
// Écran de l'équipe pédagogique
//==============================================================================
function equipePedagogique() {
  if ($_SESSION["MODE"] == 3) {
    $id_matiere = @$_GET["id_matiere"];
    $id_classe = @$_GET["id_classe"];
    $id_eleve = @$_GET["id_eleve"];
    echo '<p class="bienvenue">Bienvenue '.$_SESSION["PRENOM"].',<br></p>';
    echo '<form class="questions" method="get" action="equipePedagogique.php'.getQueryParams().'">';
    echo 'Recherchez par';
    echo '<select class="choix" name="id_matiere" required>';
    echo '<option selected="true" disabled="disabled">Matière</option>';
    $db = db_connect();
    $req = $db->query("SELECT M.*, I.prenom as prenomProf, I.nom as nomProf FROM Matieres M, Intervenants I WHERE M.id_intervenant = I.ID_intervenant ORDER BY nomProf ASC");
    while ($data = $req->fetch()) {
      $selected = "";
      if ($id_matiere == $data["ID_matiere"]) {
        $selected = 'selected="true"';
      }
      echo '<option '.$selected.' value="'.$data["ID_matiere"].'">'.$data["nomProf"].' '.$data["prenomProf"].' - '.$data["nom"].'</option>';
    }
    echo '</select>';
    echo 'et';
    echo '<select class="choix" name="id_classe" required>';
    echo '<option selected="true" disabled="disabled">Classe</option>';
    $req = $db->query("SELECT * FROM Classes");
    while ($data = $req->fetch()) {
      $selected = "";
      if ($id_classe == $data["ID_classe"]) {
        $selected = 'selected="true"';
      }
      echo '<option '.$selected.' value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
    }
    echo '</select>';
    echo '<button class="chercher" type="submit">Afficher</button>';
    echo '<br>Ou';
    echo '</form>';
    echo '<form class="questions" method="get" action="equipePedagogique.php'.getQueryParams().'">';
    echo 'Recherchez par';
    echo '<select class="choix" name="id_eleve" required>';
    echo '<option selected="true" disabled="disabled">Élève</option>';
    $db = db_connect();
    $req = $db->query("SELECT * FROM Eleves ORDER BY nom ASC");
    while ($data = $req->fetch()) {
      $selected = "";
      if ($id_eleve == $data["ID_eleve"]) {
        $selected = 'selected="true"';
      }
      echo '<option '.$selected.' value="'.$data["ID_eleve"].'">'.$data["nom"].' '.$data["prenom"].'</option>';
    }
    echo '</select>';
    echo '<button class="chercher" type="input">Afficher</button>';
    echo '</form>';
    listing();
  } else {
    header("Location:../html/signin.php");
  }
}

function listing() {
  //============================================================================
  // Affichages des notes par matières
  //============================================================================
  if (isset($_GET["id_matiere"]) && isset($_GET["id_classe"])) {
    $id_matiere = $_GET["id_matiere"];
    $id_classe = $_GET["id_classe"];
    $db = db_connect();
    $req = $db->prepare("SELECT * FROM Eleves WHERE id_classe = :id_classe
                        AND id_eleve NOT IN (SELECT id_eleve FROM Notes WHERE id_matiere = :id_matiere)
                        ORDER BY nom ASC");
    $req->execute(array("id_classe" => $id_classe, "id_matiere" => $id_matiere));
    $data = $req->fetchAll();
    $nbdata = count($data);
    if ($nbdata > 0) {
      echo '<br><br><br><form class="questions" method="post" action="">';
      echo 'Ajouter une note à un élève manquant';
      echo '<select class="choix" name="id_eleve" required>';
      echo '<option selected="true" disabled="disabled">Élève</option>';
      foreach ($data as $row) {
        echo '<option value="'.$row["ID_eleve"].'">'.$row["nom"].' '.$row["prenom"].'</option>';
      }
      echo '<input type="hidden" name="id_matiere" value="'.$id_matiere.'"/>';
      echo '</select>';
      echo '<input class="chercher" type="submit" name="ajoutNote" value="Ajouter"/>';
      echo '</form>';
    }
    $req = $db->prepare("SELECT AVG(N.note) as moyenne FROM Eleves E, Matieres M, Notes N
                        WHERE M.ID_matiere = N.id_matiere AND E.ID_eleve = N.id_eleve AND M.ID_matiere = :id_matiere AND E.id_classe = :id_classe");
    $req->execute(array("id_matiere" => $id_matiere, "id_classe" => $id_classe));
    $data = $req->fetch();
    echo '<p class="bienvenue">Moyenne de la classe : '.number_format($data["moyenne"], 1).'</p>';
    $req = $db->prepare("SELECT E.*, N.* FROM Eleves E, Matieres M, Notes N
                        WHERE M.ID_matiere = N.id_matiere AND E.ID_eleve = N.id_eleve AND M.ID_matiere = :id_matiere AND E.id_classe = :id_classe
                        ORDER BY E.nom ASC");
    $req->execute(array("id_matiere" => $id_matiere, "id_classe" => $id_classe));
    $data = $req->fetchAll();
    echo '<table>';
    echo '<thead><tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Note</th>
          <th>Note de groupe</th>
          <th>Appréciation</th>
          <th>Enregistrer les modifications</th>
          <th>Supprimer les notes</th>
          </tr>
          </thead>';
    echo '<tbody>';
    foreach ($data as $row) {
      echo '<form method="post" action="">';
      echo '<tr>';
      echo '<input type="hidden" name="ID_eleve" value="'.$row["ID_eleve"].'"/>
            <input type="hidden" name="id_matiere" value="'.$row["id_matiere"].'"/>
            <td>'.$row["nom"].'</td>
            <td>'.$row["prenom"].'</td>
            <td><input type="number" name="note" step="0.1" value="'.$row["note"].'"/></td>
            <td><input type="number" name="note_groupe" step="0.1" value="'.$row["note_groupe"].'"/></td>
            <td><input type="text" name="appreciation" value="'.$row["appreciation"].'"/></td>
            <td><input type="submit" name="changeNote" value="Enregistrer"/></td>
            <td><input type="submit" name="supprimeNote" value="Supprimer"/></td>';
      echo '</tr>';
      echo '</form>';
    }
    echo '</tbody>';
    echo '</table>';
    $db = null;
  }

  //============================================================================
  // Affichages des notes par élèves
  //============================================================================
  if (isset($_GET["id_eleve"])) {
    $id_eleve = $_GET["id_eleve"];
    $db = db_connect();
    $req = $db->query("SELECT * FROM Eleves");
    $data = $req->fetch();
    $req = $db->prepare("SELECT MAX(N.note) as noteMax, MIN(N.note) as noteMin, AVG(N.note) as moyenne, N.id_matiere as idMatiere, M.nom,
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
    $req->execute(array("id_eleve" => $id_eleve, "id_classe" => $data["id_classe"]));
    $data = $req->fetchAll();
    echo '<table>';
    echo '<thead><tr>
          <th>Matière</th>
          <th>Note</th>
          <th>Note de groupe</th>
          <th>Moyenne de la classe</th>
          <th>Max</th>
          <th>Min</th>
          <th>Appréciation</th>
          <th>Enregistrer les modifications</th>
          <th>Supprimer les notes</th>
          </tr></thead>';
    echo '<tbody>';
    foreach ($data as $row) {
      echo '<form method="post">';
      echo '<tr>';
      echo '<input type="hidden" name="ID_eleve" value="'.$row["ID_eleve"].'"/>
            <input type="hidden" name="id_matiere" value="'.$row["idMatiere"].'"/>
            <td>'.$row["nom"].'</td>
            <td><input type="number" name="note" step="0.1" value="'.$row["noteEleve"].'"/></td>
            <td><input type="number" name="note_groupe" step="0.1" value="'.number_format($row["noteGroupe"],1).'"/></td>
            <td>'.number_format($row["moyenne"],1).'</td>
            <td>'.number_format($row["noteMax"],1).'</td>
            <td>'.number_format($row["noteMin"],1).'</td>
            <td><input type="text" name="appreciation" value="'.$row["appreciation"].'"/></td>';
      echo '<td><input type="submit" name="changeNote" value="Enregistrer"/></td>';
      echo '<td><input type="submit" name="supprimeNote" value="Supprimer"/></td>';
      echo '</tr>';
      echo '</form>';
    }
    echo '</tbody>';
    echo '</table>';
  }
}

//==============================================================================
// Gestion mots de passe
//==============================================================================
if (isset($_POST["changermdp"])) {
  switch ($_SESSION["MODE"]) {
    case 4:
      $table = "Eleves";
      $idtable = "ID_eleve";
      $_SESSION["MODE"] = 1;
      break;
    case 5:
      $table = "Intervenants";
      $idtable = "ID_intervenant";
      $_SESSION["MODE"] = 2;
      break;
    case 6:
      $table = "EquipePedagogique";
      $idtable = "ID_membre";
      $_SESSION["MODE"] = 3;
      break;
  }
  $default = '@'.$_SESSION["PRENOM"];
  $hache = password_hash($_POST["pass1"], PASSWORD_DEFAULT);
  if ($_POST["pass1"] == $_POST["pass2"] && $_POST["pass1"] != $default) {
    $db = db_connect();
    $req = $db->prepare("UPDATE $table SET password = :password WHERE $idtable = :idtable2");
    $req->execute(array("password" => $hache, "idtable2" => $_SESSION["ID"]));
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

//==============================================================================
// 
//==============================================================================
function getQueryParams() {
  $params = array();
  if (isset($_GET["id_matiere"])) {
    array_push($params, "id_matiere=".$_GET["id_matiere"]);
  }
  if (isset($_GET["id_classe"])) {
    array_push($params, "id_classe=".$_GET["id_classe"]);
  }
  if (isset($_GET["id_eleve"])) {
    array_push($params, "id_eleve=".$_GET["id_eleve"]);
  }
  return "?".join("&", $params);
}
?>
