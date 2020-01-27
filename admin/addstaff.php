<?php 
	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");

	if (isset($_POST['addstaff'])) {
		if (!empty($_POST['staffname']) && !empty($_POST['staffrole'])) {
			$staffUsername = $sqlconnection->real_escape_string($_POST['staffname']);
			$staffRole = $sqlconnection->real_escape_string($_POST['staffrole']);


			$addStaffQuery = "INSERT INTO tbl_staff (username ,password ,status ,role) VALUES ('{$staffUsername}' ,'1234abcd..' ,'Offline' ,'{$staffRole}') ";

			if ($sqlconnection->query($addStaffQuery) === TRUE) {
					echo "added.";
					header("Location: staff.php"); 
					exit();

				} 

				else {
					//handle
					echo "someting wong";
					echo $sqlconnection->error;
				}
		}
	}
?>