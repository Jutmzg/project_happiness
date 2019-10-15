<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; 
session_start();
?>
<?php
$msg = "";

if(isset($_POST['submit'])) {
  
  $mail = trim($_POST['mail']);
  $password = trim($_POST['password']);
  
  if($mail != "" && $password != "") {
    try {
    $sql='SELECT mail, password FROM user WHERE mail = :mail AND password = :password';
    $stmt = $connection->prepare($sql);
    $stmt->bindParam('mail', $mail, PDO::PARAM_STR);
    $stmt->bindValue('password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();
    $row   = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($count == 1 && !empty($row)) {
      $_SESSION['user_id']   = $row['id'];
      $_SESSION['sess_user'] = $row['mail'];
      header("Location: ../home/index.php"); 
    
    } else {
      $msg = "Mail ou mot de passe invalide";
    }
    
  } catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
  }
} else {
  $msg = "Les deux champs doivent être remplis";
}
}
?>
<body>
  <div action="login.php" class="container login col-lg-4 col-sm-6 text-center">
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

  <?php require '../layout/footer.php'; ?>
  
</body>

</html>