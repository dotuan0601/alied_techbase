<?php
include 'connect_to_database.php'; 
if(empty($_SESSION))
   session_start();

if(!isset($_SESSION['username'])) {
   header("Location: login.php"); // send to login page
   exit;
} 
?>
<html>
<body>
Xin chao, <?php echo $_SESSION['username']; ?>,
 <a href="logout.php">logout</a> 
</body>
</html> 