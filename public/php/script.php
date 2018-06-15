<?php

if(isset($_POST["login"])){
  $db = db_connect();
  $req = $db->prepare("SELECT * FROM Eleves WHERE email = :email AND password = :password");
  $req->execute(array("email" => $_POST["email"],"password" => $_POST["password"]));
  if($data = $req->fetch()){
    $_SESSION["ID"] = $data["ID_eleve"];
    $_SESSION["PRENOM"] = $data["prenom"];
    header("Location:../html/eleves.php");
  }
  else{
    $req = $db->prepare("SELECT * FROM Intervenants WHERE email = :email AND password = :password");
    $req->execute(array("email" => $_POST["email"],"password" => $_POST["password"]));
    if($data = $req->fetch()){
      $_SESSION["ID"] = $data["ID_intervenant"];
      $_SESSION["PRENOM"] = $data["prenom"];
      header("Location:../html/intervenants.php");
    }
    else{
      $req = $db->prepare("SELECT * FROM EquipePedagogique WHERE email = :email AND password = :password");
      $req->execute(array("email" => $_POST["email"],"password" => $_POST["password"]));
      if($data = $req->fetch()){
        echo "admin";
      }
      else{
        echo "Erreur";
      }
    }
  }
  $db = null;
}

function eleve(){
  $db = db_connect();
  $req = $db->prepare("SELECT c.* FROM Classes as c, Eleves as e WHERE c.ID_classe = e.id_classe AND e.ID_eleve = :id_eleve");
  $req->execute(array("id_eleve" => $_SESSION["ID"]));
  $classe = $req->fetch();
  $req = $db->prepare("SELECT AVG(note) as moyenne FROM Notes WHERE id_eleve = :id_eleve");
  $req->execute(array("id_eleve" => $_SESSION["ID"]));
  $data = $req->fetch();
  echo 'Bienvenue '.$_SESSION["PRENOM"].', votre moyenne générale est de '. number_format($data["moyenne"], 1).'/20<br>';
  $req = $db->prepare("SELECT MAX(N.note) as noteMax, MIN(N.note) as noteMin, N.id_matiere as idMatiere, M.nom,
                        (SELECT note FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as noteEleve,
                        (SELECT appreciation FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as appreciation,
                        (SELECT note_groupe FROM Notes WHERE id_eleve = :id_eleve AND id_matiere = idMatiere) as noteGroupe
                      FROM Notes N, Eleves E, Classes C, Matieres M
                      WHERE
                      N.id_eleve = E.ID_eleve
                      AND E.id_classe = C.ID_classe
                      AND C.ID_classe = :id_classe
                      AND N.id_matiere = M.ID_matiere
                      GROUP BY N.id_matiere");
  $req->execute(array("id_eleve" => $_SESSION["ID"],"id_classe" => $classe["ID_classe"]));
  $data = $req->fetchAll();
  echo '<table>';
  echo '<thead><tr><th>Matière</th><th>Note</th><th>Note de groupe</th><th>Max</th><th>Min</th>Appréciation</th></tr></thead>';
  echo '<tbody>';
  foreach($data as $row){
    echo '<tr>
      <td>'.$row["nom"].'</td>
      <td>'.$row["noteEleve"].'</td>
      <td>'.number_format($row["noteGroupe"], 1).'</td>
      <td>'.$row["noteMax"].'</td>
      <td>'.$row["noteMin"].'</td>
      <td>'.$row["appreciation"].'</td>
      </tr>';
  }
  echo '</tbody>';
}

function intervenant(){
  echo 'Bienvenue '.$_SESSION["PRENOM"];
}

function intervenantRecherche(){
  echo '<form method="post" action="intervenants.php">';
  echo '<select name="id_matiere">';
  echo '<option selected="true" disabled="disabled">Matière ?</option>';
  $db = db_connect();
  $req = $db->prepare("SELECT * FROM Matieres WHERE id_intervenant = :id_intervenant");
  $req->execute(array("id_intervenant" => $_SESSION["ID"]));
  while($data = $req->fetch()){
    echo '<option value="'.$data["ID_matiere"].'">'.$data["nom"].'</option>';
  }
  echo '</select>';
  echo '<select name="id_classe">';
  echo '<option selected="true" disabled="disabled">Classe ?</option>';
  $req = $db->query("SELECT * FROM Classes");
  while($data = $req->fetch()){
    echo '<option value="'.$data["ID_classe"].'">'.$data["nom"].'</option>';
  }
  echo '</select>';
  echo '<input type="submit" name="intervenantChercher" value="Chercher"/>';
  echo '</form>';
}

if(isset($_POST["intervenantChercher"])){
  $db = db_connect();
  $req = $db->prepare("SELECT e.*, n.* FROM Eleves as e, Matieres as m, Notes as n WHERE m.ID_matiere = n.id_matiere AND e.ID_eleve = n.id_eleve AND m.ID_matiere = :id_matiere AND e.id_classe = :id_classe");
  $req->execute(array("id_matiere" => $_POST["id_matiere"],"id_classe" => $_POST["id_classe"]));
  $_SESSION["id_matiere"] = $_POST["id_matiere"];
  $data = $req->fetchAll();
  echo '<table>';
  echo '<thead><tr><th></th><th>Élève</th><th>Note</th><th>Note de groupe</th><th>Appréciation</th></tr></thead>';
  echo '<tbody>';
  foreach($data as $row){
    echo '<form method="post">';
    echo '<tr>';
    echo '<td><input type="hidden" name="ID_eleve" value="'.$row["ID_eleve"].'"/></td><td>'.$row["nom"].'</td><td><input type="number" name="note" step="0.1" value="'.$row["note"].'" /></td><td><input type="number" name="note_groupe" step="0.1" value="'.$row["note_groupe"].'" /></td><td><input type="text" name="appreciation" value="'.$row["appreciation"].'" /></td>';
    echo '<td><input type="submit" name="changeNote" value="Modifier"/></td>';
    echo '</tr>';
    echo '</form>';
  }
  echo '</tbody>';
}

if(isset($_POST["changeNote"])){
  $db = db_connect();
  $req = $db->prepare("UPDATE Notes SET note = :note, appreciation = :appreciation, note_groupe = :note_groupe WHERE id_eleve = :id_eleve AND id_matiere = :id_matiere");
  $req->execute(array("id_eleve" => $_POST["ID_eleve"],"id_matiere" => $_SESSION["id_matiere"],"note" => $_POST["note"],":appreciation" => $_POST["appreciation"],"note_groupe" => $_POST["note_groupe"]));
}




/*
if(isset($_POST["createAccount"])){
  if((empty($_POST["currency"]) || empty($_POST["type"]))){
    echo "Remplissez le formulaire";
  }else{
    if(!(strlen($_POST["name"]) >= 1 && strlen($_POST["name"]) <= 20)){
      echo "ERREUR : Le nom doit contenir entre 1 et 20 caractères";
    }elseif(!($_POST["type"] == "courant" || $_POST["type"] == "epargne" || $_POST["type"] == "joint") || empty($_POST["type"])){
      echo "ERREUR : Veuillez choisir l'un des types de compte proposés";
    }elseif(!is_numeric($_POST["fund"])){
      echo "ERREUR : Veuillez entrer un nombre valide";
    }elseif(!($_POST["currency"] == "EUR" || $_POST["currency"] == "USD") || empty($_POST["currency"])){
      echo "ERREUR : Veuillez choisir l'une des devises proposées";
    }else{
      $db = db_connect();
      $check = $db->query("SELECT COUNT(id) as countAccount FROM GestionPanda WHERE ID_user = 1");
      $data = $check->fetch();
      if($data["countAccount"] >= 10){
        echo "ERREUR : Vous ne pouvez pas avoir plus de 10 comptes virtuels";
      }else{
        $db = db_connect();
        $check = $db->prepare("SELECT * FROM GestionPanda WHERE name_account = :name");
        $check->execute(array("name" => $_POST["name"]));
        $data = $check->fetch();
        if($data["name_account"] == $_POST["name"]){
          echo "ERREUR : Vous ne pouvez pas avoir 2 comptes avec le même nom";
        }else{
          inserer();
        }
      }
    }
  }
}

function inserer(){
  $db = db_connect();
  $req = $db->prepare("INSERT INTO GestionPanda(ID_user, name_account, type_account, fund, currency) VALUES (1,:name,:type,:fund,:currency)");
  $req->execute(array("name" => $_POST["name"],"type" => $_POST["type"],"fund" => $_POST["fund"],"currency" => $_POST["currency"]));
}

function listAccount(){
  $db = db_connect();
  $req = $db->query("SELECT * FROM Classes");
  //$req->execute(array("idUser" => 1));
  while($data = $req->fetch()){
    echo '<form method="POST" action="index.php">';
    echo "<tr>";
    echo '<td><input type="hidden" name="idAcc" value="' . $data['id'] . '" /><input type="text" name="name" value="' . $data['nomClasse'] . '" /></td>';
    echo '<td><input type="number" name="fund" value="' . $data['fund'] . '" /></td>';
    echo '<td>';
    echo '<select name="type">';
    echo '<option >Choissisez un type de compte</option>';
    echo '<option value="courant" '. (($data['type_account'] == "courant") ? "selected" : "") .' >Courant</option>';
    echo '<option value="epargne" '. (($data['type_account'] == "epargne") ? "selected" : "") .'>Épargne</option>';
    echo '<option value="joint" '. (($data['type_account'] == "joint") ? "selected" : "") .'>Compte joint</option>';
    echo '</select>';
    echo '</td>';
    echo '<td><select name="currency">';
    echo '<option value="EUR" '. (($data['currency'] == "EUR") ? "selected" : "") .' >EUR</option>';
    echo '<option value="USD" '. (($data['currency'] == "USD") ? "selected" : "") .' >USD</option>';
    echo '<td><input type="submit" value="modifier" name="editAccount" /></td>';
    echo '<td><input type="submit" value="X" name="deleteAccount" /></td>';
    echo '</tr>';
    echo '</form>';
  }
}

if(isset($_POST['deleteAccount'])){
  $db = db_connect();
  $req = $db->prepare("DELETE FROM GestionPanda WHERE GestionPanda.id =   ?");
  $req->execute(array($_POST['idAcc']));
}



if(isset($_POST["gestionAccount"])){
  if(empty($_POST["choix"]) || empty($_POST["categorie"]) || empty($_POST["mode"])){
    echo "Remplissez le formulaire BOWDEL";
  }else{
    $db = db_connect();
    $check = $db->prepare("SELECT name_account FROM GestionPanda WHERE name_account = :operation_name");
    $check->execute(array("operation_name" => $_POST["operation_name"]));
    $data = $check->fetch();
    if(!($data["operation_name"]$_POST["choix"])){
      echo "ERREUR : Veuillez choisir l'un des comptes proposés";
    }elseif(!(strlen($_POST["operation_name"]) >= 1 && strlen($_POST["operation_name"]) <= 35)){
      echo "ERREUR : Le nom doit contenir entre 1 et 35 caractères";
    }elseif(!is_numeric($_POST["montant"])){
      echo "ERREUR : Veuillez entrer un nombre valide";
    }elseif(!()){
      echo "ERREUR : Veuillez choisir l'une des devises proposées";
    }else{
      //faire
    }
  }
}
*/
?>
