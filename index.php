<?php
	session_start();
	if(isset($_SESSION['user_id'])){
		header("Location: homepage.php");
	}
	else{
		session_destroy();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<title>Todolist</title>
	</head>
	<body class="loginBody">
		<div class="container h-100">
			<div class="row justify-content-center align-items-center h-100 login ">
				<div class="col-lg-6 col-sm-12 mx-auto shadow text-center login">
					<h1>Login</h1>
					<form action="app/authenticate.php" method="post">
						<div class="form-group">
							<label for="username">
							</label>
							<input type="text" name="username" placeholder="Username" id="username" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="password">
							</label>
							<input type="password" name="password" placeholder="Password" id="password" class="form-control" required>
						</div>
						<input type="submit" value="Login" class="btn btn-primary submit-login">
					</form>
					<a href="register.php">Registrieren</a>
				</div>
			</div>
		</div>
	</body>
</html>