<?php
function tableStudents($data, $id_matiere, $id_classe) {
  ?>
  <table>
  <thead><tr>
        <th></th>
        <th></th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Note</th>
        <th>Note de groupe</th>
        <th>Appréciation</th>
        </tr></thead>
  <tbody>
  <?php
    foreach($data as $row) {
  ?>
    <form method="post" action="?id_matiere=<?php echo $id_matiere; ?>&id_classe=<?php echo $id_classe; ?>">
    <tr>
      <td><input type="hidden" name="ID_eleve" value="<?php echo $row["ID_eleve"]; ?>"/></td>
          <td><input type="hidden" name="id_matiere" value="<?php echo $row["id_matiere"]; ?>"/></td>
          <td><?php echo $row["nom"]; ?></td>
          <td><?php echo $row["prenom"]; ?></td>
          <td><input type="number" name="note" step="0.1" value="<?php echo $row["note"]; ?>"/></td>
          <td><input type="number" name="note_groupe" step="0.1" value="<?php echo $row["note_groupe"]; ?>"/></td>
          <td><input type="text" name="appreciation" value="<?php echo $row["appreciation"]; ?>"/></td>
          <td><input type="submit" name="changeNote" value="Modifier"/></td>
          <td><input type="submit" name="supprimeNote" value="Supprimer"/></td>
        </tr>
    </form>
  <?php
   }
  ?>
  </tbody>
  </table>
  <?php
}
?>
