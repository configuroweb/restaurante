<?php
	
	//Add new menu (category)
	if (isset($_POST['addmenu'])) {

		if (!empty($_POST['menuname'])) {
			$menuname = $sqlconnection->real_escape_string($_POST['menuname']);

			$addMenuQuery = "INSERT INTO tbl_menu (menuName) VALUES ('{$menuname}')";

			if ($sqlconnection->query($addMenuQuery) === TRUE) {
				header("Location: menu.php");
			} else {
				//handle
				echo "someting wong";
			}
		}

		//No input handle
		else {
			echo "Jangan bia kosong bang 12";
		}

	}


?>