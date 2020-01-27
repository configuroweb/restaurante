<?php

	if (isset($_POST['deletemenu'])) {

		//Deleting Menu
		if (isset($_POST['menuID'])) {
			
			$menuID = $sqlconnection->real_escape_string($_POST['menuID']);

			//delete all item in this menu first
			$deleteMenuItemQuery = "DELETE FROM tbl_menuitem WHERE menuID = {$menuID}";

			if ($sqlconnection->query($deleteMenuItemQuery) === TRUE) {

				//them delete the menu after deleting all the item in this menu
				$deleteMenuQuery = "DELETE FROM tbl_menu WHERE menuID = {$menuID}";

				if ($sqlconnection->query($deleteMenuQuery) === TRUE) {
					header("Location: menu.php"); 
					exit();
					} 
				else {
						//handle
						echo "someting wrong";
						echo $sqlconnection->error;
					}
				} 

			else {
					//handle
					echo "someting wrong";
					echo $sqlconnection->error;
				}
			//echo "<script>alert('{$del_menuID} & {$del_itemID}')</script>";
		}
	}
	

?>