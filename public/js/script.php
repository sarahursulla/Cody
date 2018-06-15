<?php

if(isset($_POST["login"])){
  $db = db_connect();
  $req = $db->prepare("SELECT * FROM Eleves WHERE email = :email AND password = :password");
  $req->execute(array("email" => $_POST["email"],"password" => $_POST["password"]));
  if($data = $req->fetch()){
    $_SESSION["ID_ELEVE"] = $data["ID_eleve"];
    header("Location:../html/eleves.php");
  }
  else{
    $req = $db->prepare("SELECT * FROM Intervenants WHERE email = :email AND password = :password");
    $req->execute(array("email" => $_POST["email"],"password" => $_POST["password"]));
    if($data = $req->fetch()){
      echo $data["prenom"];
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
  $req = $db->prepare("SELECT m.*, n.* FROM Matieres as m, Notes as n WHERE m.ID_matiere = n.id_matiere AND n.id_eleve = :id_eleve");
  $req->execute(array("id_eleve" => $_SESSION["ID_ELEVE"]));
  $data = $req->fetchAll();
  foreach($data as $row){
    echo $row['nom'].' | '.$row['note'].' | '.$row['note_groupe'].' | '.$row['appreciation'].'<br>';
  }
}

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


/*
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
