<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

$id = $_GET['id'];
if($id == ""){
  header('Location: /Akkappiness/consultant/show.php');
}

$sql = 'SELECT * FROM consultant WHERE id=:id';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id]);
$row = $statement->fetch(PDO::FETCH_OBJ);

$sql2 = "SELECT id, mail, CONCAT(lastname,' ', firstname) as fullname FROM manager WHERE state = 0 ORDER BY fullname";
$statement = $connection->query($sql2);
$statement->execute();
$managers = $statement->fetchAll(PDO::FETCH_OBJ);
if (
    isset($_POST['lastname']) &&
    isset($_POST['firstname']) &&
    isset($_POST['mail']) &&
    isset($_POST['manager_id'])
) {

    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $mail = $_POST['mail'];
    $manager_id = $_POST['manager_id'];
    $state = 0;

    $sql = 'UPDATE consultant SET lastname=:lastname, firstname=:firstname, mail=:mail, state=:state, manager_id=:manager_id WHERE id=:id';
    $statement = $connection->prepare($sql);

    if ($statement->execute([':lastname' => $lastname, ':firstname' => $firstname, ':mail' => $mail, ':state' => $state, ':manager_id' => $manager_id, ':id' => $id])) {
        header("Location: show.php");
    }
}
?>

<body>
    <div class="container">
        <div class="box">
            <form method="post">
                <h2>Modifier les informations de <?= $row->firstname . ' ' . $row->lastname ?></h2>
                <a onclick="goBack()"> <i class="fas fa-times fa-2x" id="cross"></i></a>

                <div class="input-box">
                    <input value="<?= $row->lastname; ?>" type="text" name="lastname" id="lastname" maxlength="50" minlength="2" required>
                </div>
                <div class="input-box">
                    <input value="<?= $row->firstname; ?>" type="text" name="firstname" id="firstname" maxlength="50" minlength="2" required>
                </div>
                <div class="input-box">
                    <input value="<?= $row->mail; ?>" type="email" name="mail" id="mail" placeholder="Email" maxlength="50" minlength="5" required>
                </div>
                <div class="input-box">
                    <select name="manager_id" required>
                        <option name="choice" id="choice" value="">Sélectionner un manager</option>
                        <?php foreach ($managers as $manager) { ?>
                            <?php $selected = $row->manager_id == $manager->id ? 'selected' : ''; ?>
                            <?= "<option value='$manager->id' name='manager_id' id='manager_id' $selected>" ?><?= utf8_encode($manager->fullname) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-box">
                        <button type="submit" class="btn btn-info">Valider</button>
                        <button class="btn btn-info retour"><a onclick="goBack()">Annuler</a></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</body>
<?php require '../layout/footer.php'; ?>

</html>