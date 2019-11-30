<?php
    session_start();
	unset($_SESSION["USERID"]); 
	unset($_SESSION["FULLNAME"]);  
	$currentUser = null; 

	header('Location: index.php'); 
	exit();
?>