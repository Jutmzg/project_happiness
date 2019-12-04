<!DOCTYPE html>
<html lang="fr">
<?php require '../config.php'; ?>
<?php require '../connection.php'; ?>

<head>
<link href="../assets/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>

<?php


$host = 'localhost';

// nom de la base données
$bdd = 'akkappiness';

// identifiant mySQL
$username = 'root';

// mot de passe mySQL
$password = 'fev2019FAQ';


$dsn = "mysql:host=$host;dbname=$bdd";
$options = [];
try {
    $connection = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e) {
}

if(!empty($_POST)) {

    $errors = [];
    if (empty($_POST['mail'])) {
        $errors['mail'] = 'Vous n\'avez pas entré de mail';
    } else {
        $sql = "SELECT mail FROM user WHERE mail = :mail";
        $statement = $connection->prepare($sql);
        $statement->execute([':mail' => $_POST['mail']]);
        $mail = $statement->fetchAll(PDO::FETCH_OBJ);

        if ($mail) {
            $errors['mail'] = 'Cet email est déjà utilisé';
        }

    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Vous n\'avez pas entré de mot de passe';
    }
    if (empty($errors)) {

        $sql = "INSERT INTO user(mail,password) VALUES(:mail, :password)";
         
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $statement = $connection->prepare($sql);
        $statement->execute([':mail' => $_POST['mail'], ':password' => $password]);
        echo 'Inscription effectuée';
        header('Location: /user/login');
    } else {
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) { ?>
            <p><?= $error; ?></p>

        <?php } ?>
<?= '</div>'?>
 <?php

    }
}
?>

 <body>
  <div class="container login col-lg-4 col-sm-6 text-center">
    <form method="post" action="">
      <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" name="mail" class="form-control" value="" placeholder="Enter email" >
      </div>
      <div class="form-group mt-4">
        <label for="exampleInputPassword1">Mot de passe</label>
        <input type="password" name="password" class="form-control" value="" placeholder="Password" >
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-info connexion" name="connexion" value="Connexion">Inscription</button>
      </div>
    </form>
  </div>

  <?php require '../layout/footer.php'; ?>
  
</body>

</html>
