<?php
require_once 'init.php';
require_once 'key.php';

session_start();


if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}
else{
	$userQuery = $db->prepare("
		SELECT * FROM user
		WHERE name = :name
	");
	$userQuery->execute([
		'name' => trim($_POST['username'])
	]);
	$user = $userQuery->fetch();
	if(!empty($user)){
		if(password_verify($_POST['password'], $user['password'])){
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['username'] = $user['name'];
			$_SESSION['key'] = decryptData($user['cipher_key'], hash_pbkdf2("sha256", $_POST['password'], "23z8eufh23o78hbjsfc".$user['cipher_salt'], 4000));
			header("Location: ../homepage.php");
		}	
		else{

		}
	}
	else{
		header("Location: ../index.php");
	}
}