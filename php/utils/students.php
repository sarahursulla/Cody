<?php
function findStudents ($db, $idMatiere, $idClasse) {
  $req = $db->prepare("SELECT e.*, n.* FROM Eleves as e, Matieres as m, Notes as n
                      WHERE m.ID_matiere = n.id_matiere AND e.ID_eleve = n.id_eleve AND m.ID_matiere = :id_matiere AND e.id_classe = :id_classe
                      ORDER BY e.nom ASC");
  $req->execute(array("id_matiere" => $idMatiere, "id_classe" => $idClasse));

  return $req->fetchAll();
}
?>
