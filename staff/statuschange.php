<?php

  include("../functions.php");

  if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
    header("Location: login.php");

  if($_SESSION['user_level'] != "staff")
    header("Location: login.php");


	if (isset($_POST['btnStatus']) && isset($_POST['staffid'])) {

		$btnStatus = $sqlconnection->real_escape_string($_POST['btnStatus']);
		$staffID = $sqlconnection->real_escape_string($_POST['staffid']);

		if ($btnStatus== "Online")
			$status = "Offline";

		if ($btnStatus== "Offline")
			$status = "Online";
		
		$addOrderQuery = "UPDATE tbl_staff SET status = '{$status}' WHERE staffID = {$staffID};";

		if ($sqlconnection->query($addOrderQuery) === TRUE) {
				header("Location: index.php");
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}
	}
?>