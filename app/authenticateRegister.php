<?php
	require_once 'init.php';
	require_once 'key.php';
	 
	if(isset($_POST['submit'])) {
	    $error = false;
	    $username = $_POST['username'];
	    $password = $_POST['password'];
	    $password2 = $_POST['password2'];
	   
	    if(strlen($password) == 0) {
	        echo 'Select a password';
	        $error = true;
	    }
	    if($password != $password2) {
	        echo 'Passwords are not equal';
	        $error = true;
	    }
	    if(strpos($password, " ") == true || strpos($username, " ") == true) {
	        echo 'There is whitespace in your username or password';
	        $error = true;
	    }
	    
	    if(!$error) { 
	        $statement = $db->prepare("SELECT * FROM user WHERE name = :name");
	        $result = $statement->execute(array('name' => $username));
	        $user = $statement->fetch();
	        
	        if($user !== false) {
	            echo 'The Username is already taken';
	            $error = true;
	        }    
	    }
	    

	    if(!$error) {    
	        $password_hash = password_hash($password, PASSWORD_DEFAULT);
	        $salt = generateSalt();
	        
	        $statement = $db->prepare("
		        	INSERT INTO user (name, password, cipher_key, cipher_salt) 
		        	VALUES (:name, :password, :cipher_key, :cipher_salt)
	        ");
	        $result = $statement->execute([
	        	'name' => $username,
	        	'password' => $password_hash,
	        	'cipher_key' => encryptData(generateKey(), hash_pbkdf2("sha256", $password, "23z8eufh23o78hbjsfc".$salt, 4000)),
	        	'cipher_salt' => $salt
	        ]);
	        
	        if($result) {        
	            echo 'Success. <a href="index.php">Login</a>';
	        } else {
	            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
	        }
	    } 
	}
?>