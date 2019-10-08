<?php require '../layout/header.php';?>
<div action="login.php" class="container login col-6">
<form method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" name="login" class="form-control" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Mot de passe</label>
    <input type="password" name="pass" class="form-control" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary" name="connexion" value="Connexion">Se Connecter</button>
</form>
</div>

<?php require '../layout/footer.php'; ?>
<?php 
session_start();
require '../db/db.php';

	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {

    $connection = new PDO($dsn, $username, $password, $options);
            
	$sql = 'SELECT * FROM user WHERE mail=? AND password=?';
    $statement = $connection->prepare($sql);
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $statement->execute(array($login, $pass));
        if($statement->rowCount()== 1){
            $_SESSION['login'] = $login;
            $_SESSION['pass'] = $pass;
        }
		
		
		header('Location: ../home/index.php');
		exit();
	}
?>
