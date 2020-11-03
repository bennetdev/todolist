<!DOCTYPE html> 
<html> 
<head>
  	<title>Registrierung</title>    
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head> 
<body class="loginBody">
		<div class="container h-100">
			<div class="row justify-content-center align-items-center h-100 login ">
				<div class="col-lg-6 col-sm-12 mx-auto shadow text-center login">
					<h1>Register</h1>
					<form action="app/authenticateRegister.php" method="post">
						<div class="form-group">
							<label for="username">
							</label>
							<input type="text" name="username" placeholder="Username" id="username" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="password">
							</label>
							<input type="password" size="40" maxlength="250" name="password" placeholder="Password" id="password" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="password">
							</label>
							<input type="password" size="40" maxlength="250" name="password2" placeholder="Password" id="password2" class="form-control" required>
						</div>
						<input type="submit" value="Register" class="btn btn-primary submit-login" id="submit">
					</form>
					<p class="output"></p>
				</div>
			</div>
		</div>
	</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$("form").submit(function(){
			event.preventDefault();
			var username = $("#username").val();
			var password = $("#password").val();
			var password2 = $("#password2").val();
			var submit = $("#submit").val();
			$(".output").load("app/authenticateRegister.php",{
				username: username,
				password: password,
				password2: password2,
				submit: submit
			});
		});
	});
</script>