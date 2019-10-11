<?php

require '../db/db.php';

$id = $_GET['id'];

$sql = 'SELECT * FROM consultant WHERE mission_id=:id';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id]);
$row = $statement->fetch(PDO::FETCH_OBJ);
if (
    
    isset($_POST['resultat'])
) {

    $mission_id = $row->mission_id;
    $resultat = $_POST['resultat'];
    $state = 0;
    
    
    $sql = 'UPDATE enquete SET resultat=:resultat, state=:state WHERE mission_id=:mission_id';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':resultat' => $resultat,':state' => $state,':mission_id' => $mission_id])) {
    $message = 'Consultant ajouté';
  }
}

?>

<?= $row->firstname;?> <br>
<?= $row->lastname;?> <br>
<?= $row->mission_id;?> <br>
                    <div class="form-group">

<form action="" method="post">
<div class="form-group">
Comment notez vous votre mission?
<select name="resultat">
    <option value=""></option>
    <option value="1">Bien</option>
    <option value="2">Moyen</option>
    <option value="3">Mauvais</option>
</select>
</div>
<input type="submit" name="submit" value="Soumettre">
</form>
