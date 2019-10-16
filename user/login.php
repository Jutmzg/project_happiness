<!DOCTYPE html>
<html lang="fr">
<?php require '../config.php'; ?>
<?php require '../connection.php'; ?>
<?php session_start(); ?>
<head>
  <link href="../assets/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>

<?php

if (!empty($_POST) && (!empty($_POST['mail'])) && (!empty($_POST['password']))) {

  $sql = "SELECT * FROM user WHERE mail = :mail";
  $statement = $connection->prepare($sql);
  $statement->execute([':mail' => $_POST['mail']]);
  $user = $statement->fetch(PDO::FETCH_OBJ);
  if ($_POST['password'] == $user->password) {
    
    $_SESSION['login'] = $user->mail;
    header('Location: /Akkappiness');
    exit();
   
  }
  else{
    echo "<div class='alert alert-danger'>
          <p>Email ou mot de passe incorrect</p>
          </div>";
  }
}
?>

<body>
  <div class="container login col-lg-4 col-sm-6 text-center">
    <form method="post">
      <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" name="mail" class="form-control" value="" placeholder="Enter email" required>
      </div>
      <div class="form-group mt-4">
        <label for="exampleInputPassword1">Mot de passe</label>
        <input type="password" name="password" class="form-control" value="" placeholder="Password" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-info connexion" name="connexion" value="Connexion">Connexion</button>
      </div>
    </form>
  </div>
</body>

</html>