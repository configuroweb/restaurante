<?php

	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");

	if(isset($_POST['btnedit'])) {

		if (!empty($_POST['itemName']) && !empty($_POST['itemPrice']) ) {

			$menuID = $sqlconnection->real_escape_string($_POST['menuID']);
			$itemID = $sqlconnection->real_escape_string($_POST['itemID']);
			$itemName = $sqlconnection->real_escape_string($_POST['itemName']);
			$itemPrice = $sqlconnection->real_escape_string($_POST['itemPrice']);

			$updateItemQuery = "UPDATE tbl_menuitem SET menuItemName = '{$itemName}' , price = {$itemPrice} WHERE menuID = {$menuID} AND itemID = {$itemID} ";

			if ($sqlconnection->query($updateItemQuery) === TRUE) {
				header("Location: menu.php"); 
				exit();
			} 

			else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;
				echo $updateItemQuery;
			}

		}
	} 

?>