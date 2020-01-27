<?php

	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");

	//Deleting Item
	if (isset($_GET['staffID'])) {
		
		$del_staffID = $sqlconnection->real_escape_string($_GET['staffID']);

		$deleteStaffQuery = "DELETE FROM tbl_staff WHERE staffID = {$del_staffID}";

		if ($sqlconnection->query($deleteStaffQuery) === TRUE) {
				echo "deleted.";
				header("Location: staff.php"); 
				exit();
			} 

		else {
				//handle
				echo "someting wrong";
				echo $sqlconnection->error;

		}
		//echo "<script>alert('{$del_menuID} & {$del_itemID}')</script>";
	}
?>