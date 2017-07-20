<?php
include 'connect_to_database.php';
  
if(empty($_SESSION))
   session_start();
if(!isset($_POST['submit'])) {
   header("Location: login.php");
   exit; 
}
/*check if the username entered is in the database. */
$email = isset($_POST['email']) ? $_POST['email'] : '';
if ($email == '') {
	echo "The email cannot empty";
}
else {
	$check_existed = "SELECT * FROM user WHERE email = '".mysql_escape_string($email)."'";
	$check_existed_query_result = mysql_query($check_existed);

	if(mysql_num_rows($check_existed_query_result)==0) {
		//if username entered not yet exists
		echo "The email you entered is invalid.";
	}else {
		//if exists, then extract the password.
		while($row_query = mysql_fetch_array($check_existed_query_result)) {
			// check if password are equal
			if($row_query['password']==md5($_POST['password'])){
				$_SESSION['username'] = $row_query['email'];
				$_SESSION['password'] = $_POST['password'];
				header("Location: home.php");
				exit; 
			} else{ // if not
				echo "Invalid Password"; 
			}
		}
		
	}
}