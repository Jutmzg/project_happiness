<?php
session_start();

require_once '../connection.php';

if ( !isset($_POST['mail'], $_POST['password']) ) {
	die ('Please fill both the username and password field!');
}

if ($stmt = $con->prepare('SELECT mail, password FROM user WHERE mail = ?')) {
	$stmt->bind_param('s', $_POST['mail']);
	$stmt->execute();
	$stmt->fetch();
}

if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password);
	$stmt->fetch();
	
	if (password_verify($_POST['password'], $password)) {
		
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['user'] = $_POST['mail'];
		$_SESSION['id'] = $id;
		echo 'Welcome ' . $_SESSION['user'] . '!';
	} else {
		echo 'Incorrect password!';
	}
} else {
	echo 'Incorrect username!';
}
$stmt->close();
?>