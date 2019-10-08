<?php
require '../db/db.php';
$id = $_GET['id'];

$sql = 'SELECT * FROM consultant WHERE id=:id';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id]);
$row = $statement->fetch(PDO::FETCH_OBJ);

$sql2 = 'SELECT * FROM mission WHERE state = 0';
$statement = $connection->query($sql2);
$statement->execute();
$missions = $statement->fetchAll(PDO::FETCH_OBJ);

$sql2 = "SELECT id, mail, CONCAT(firstname,' ', lastname) as fullname FROM manager WHERE state = 0";
$statement = $connection->query($sql2);
$statement->execute();
$managers = $statement->fetchAll(PDO::FETCH_OBJ);
if (
    isset($_POST['lastname']) &&
    isset($_POST['firstname']) &&
    isset($_POST['mail']) &&
    isset($_POST['mission_id']) &&
    isset($_POST['manager_id'])
) {

    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $mail = $_POST['mail'];
    if ($_POST['mission_id'] == '') {
        $mission_id = NULL;
      } else {
        $mission_id = $_POST['mission_id'];
      }
    $manager_id = $_POST['manager_id'];
    $state = 0;

    $sql = 'UPDATE consultant SET lastname=:lastname, firstname=:firstname, mail=:mail, mission_id=:mission_id, state=:state, manager_id=:manager_id WHERE id=:id';
    $statement = $connection->prepare($sql);

    if ($statement->execute([':lastname' => $lastname, ':firstname' => $firstname, ':mail' => $mail, ':mission_id' => $mission_id, ':state' => $state, ':manager_id' => $manager_id, ':id' => $id])) {
        header("Location: show.php");
    }
}
?>
<?php require '../layout/header.php'; ?>
<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            <h2>Modifier les informations de <?= $row->firstname . ' ' . $row->lastname ?></h2>
            <a href ="/Akkappiness/consultant/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>

        </div>
        <div class="card-body">
            <?php if (!empty($message)) : ?>
                <div class="alert alert-success">
                    <?= $message; ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input value="<?= $row->lastname; ?>" type="text" name="lastname" id="lastname" class="form-control" maxlength="50" minlength="2" required>
                </div>
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input value="<?= $row->firstname; ?>" type="text" name="firstname" id="firstname" class="form-control" maxlength="50" minlength="2" required>
                </div>
                <div class="form-group">
                    <label for="mail">Email</label>
                    <input value="<?= $row->mail; ?>" type="email" name="mail" id="mail" class="form-control"  maxlength="50" minlength="5" required>
                </div>
                </select>
                <div class="form-group">
                    <label for="mission">Mission</label>
                    <select name="mission_id" class="form-control">
                        <option name="choice" id="choice"></option>
                        <?php foreach ($missions as $mission) {
                            $selected = $row->mission_id == $mission->ID ? 'selected' : '';
                            echo "<option value='$mission->ID' name='mission_id' id='mission_id' $selected>$mission->name</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="manager">Mission</label>
                    <select name="manager_id" class="form-control"required>
                        <option name="choice" id="choice" value="">Selectionner un manager</option>
                        <?php foreach ($managers as $manager) {
                            $selected = $row->manager == $manager->ID ? 'selected' : '';
                            echo "<option value='$manager->id' name='manager_id' id='manager_id' $selected>$manager->fullname</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info">Valider</button>
                    <button class="btn btn-info retour"><a href ="/Akkappiness/consultant/show.php">Retour</a></button>

                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php require '../layout/footer.php'; ?>