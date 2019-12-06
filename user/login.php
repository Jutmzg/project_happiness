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
  if (password_verify($_POST['password'], $user->password)) {
    
    $_SESSION['login'] = $user->mail;
    header('Location: /');
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
      <div class="input-box">
        <input type="email" name="mail" value="" placeholder="Email" required>
      </div>
      <div class="input-box mt-4">
        <input type="password" name="password" value="" placeholder="Mot de passe" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-info connexion" name="connexion" value="Connexion">Se Connecter</button>
      </div>
    </form>
  </div>
</body>

</html>