<?php
include 'connect_to_database.php'; //connect database

/* check session started or not */
if(empty($_SESSION)) 
   session_start();

/* redirect to homepage if already login */
if(isset($_SESSION['username'])) {
   header("location: home.php");
   exit; 
}

?>

<html>
	<head>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<form action = "login_confirm.php" method = "post">
			Email: <input type="email" name="email" /><br />
			Password: <input type="password" name="password" /><br />
		<input type = "submit" name="submit" value="login" />
	</form>
	</body>
</html>