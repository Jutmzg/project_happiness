<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; ?>
<body>
  <div action="connect.php" class="container login col-lg-4 col-sm-6 text-center">
    <form method="post">
      <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" name="login" class="form-control" value="<?php if (isset($_SESSION['login'])) echo htmlentities(trim($_SESSION['login'])); ?>" placeholder="Enter email">
      </div>
      <div class="form-group mt-4">
        <label for="exampleInputPassword1">Mot de passe</label>
        <input type="password" name="pass" class="form-control" value="<?php if (isset($_SESSION['pass'])) echo htmlentities(trim($_SESSION['pass'])); ?>" placeholder="Password">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-info connexion" name="connexion" value="Connexion">Connexion</button>
      </div>
    </form>
  </div>
<?php require '../layout/footer.php'; ?>
</body>
</html>