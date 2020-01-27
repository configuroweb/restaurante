<?php
	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "staff")
		header("Location: login.php");

	if (isset($_POST['btnMenuID'])) {

		$menuID = $sqlconnection->real_escape_string($_POST['btnMenuID']);

		$menuItemQuery = "SELECT itemID,menuItemName FROM tbl_menuitem WHERE menuID = " . $menuID;

		if ($menuItemResult = $sqlconnection->query($menuItemQuery)) {
			if ($menuItemResult->num_rows > 0) {
				$counter = 0;
				while($menuItemRow = $menuItemResult->fetch_array(MYSQLI_ASSOC)) {

					if ($counter >=3) {
						echo "</tr>";
						$counter = 0;
					}

					if($counter == 0) {
						echo "<tr>";
					}

					echo "<td><button style='margin-bottom:4px;white-space: normal;' class='btn btn-warning' onclick = 'setQty({$menuItemRow['itemID']})'>{$menuItemRow['menuItemName']}</button></td>";

					$counter++;
				}
			}

			else {
				echo "<tr><td>No item in this menu</td></tr>";
			}
			
		}
	}

	if (isset($_POST['btnMenuItemID']) && isset($_POST['qty'])) {
		
		$menuItemID = $sqlconnection->real_escape_string($_POST['btnMenuItemID']);
		$quantity = $sqlconnection->real_escape_string($_POST['qty']);

		$menuItemQuery = "SELECT mi.itemID,mi.menuItemName,mi.price,m.menuName FROM tbl_menuitem mi LEFT JOIN tbl_menu m ON mi.menuID = m.menuID WHERE itemID = " . $menuItemID;

		if ($menuItemResult = $sqlconnection->query($menuItemQuery)) {
			if ($menuItemResult->num_rows > 0) {
				if ($menuItemRow = $menuItemResult->fetch_array(MYSQLI_ASSOC)) {
					echo "
					<tr>
						<input type = 'hidden' name = 'itemID[]' value ='".$menuItemRow['itemID']."'/>
						<td>".$menuItemRow['menuName']." : ".$menuItemRow['menuItemName']."</td>
						<td>".$menuItemRow['price']."</td>
						<td><input type = 'number' required='required' min='1' max='50' name = 'itemqty[]' width='10px' class='form-control' value ='".$quantity."'/></td>
						<td>" . number_format((float)$menuItemRow['price'] * $quantity, 2, '.', '') . "</td>
						<td><button class='btn btn-danger deleteBtn' type='button' onclick='deleteRow()'><i class='fas fa-times'></i></button></td>
					</tr>
					";
				}
			}

			else {
				//no data retrieve
				echo "null";
			}
			
		}

	}

	
?>