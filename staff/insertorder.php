<?php
	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "staff")
		header("Location: login.php");

	

	if (isset($_POST['sentorder'])) {

		if (isset($_POST['itemID']) && isset($_POST['itemqty'])) {

			$arrItemID = $_POST['itemID'];
			$arrItemQty = $_POST['itemqty'];			

			//check pair of the array have same element number
			if (count($arrItemID) == count($arrItemQty)) {				
				$arrlength = count($arrItemID);

				//add new id
				$currentOrderID = getLastID("orderID","tbl_order") + 1;

				insertOrderQuery($currentOrderID);

				for ($i=0; $i < $arrlength; $i++) { 
					insertOrderDetailQuery($currentOrderID,$arrItemID[$i] ,$arrItemQty[$i]);
				}

				updateTotal($currentOrderID);

				//completed insert current order
				header("Location: index.php");
				exit();
			}

			else {
				echo "xD";
			}
		}	
	}

	function insertOrderDetailQuery($orderID,$itemID,$quantity) {
		global $sqlconnection;
		$addOrderQuery = "INSERT INTO tbl_orderdetail (orderID ,itemID ,quantity) VALUES ('{$orderID}', '{$itemID}' ,{$quantity})";

		if ($sqlconnection->query($addOrderQuery) === TRUE) {
				echo "inserted.";
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}
	}

	function insertOrderQuery($orderID) {
		global $sqlconnection;
		$addOrderQuery = "INSERT INTO tbl_order (orderID ,status ,order_date) VALUES ('{$orderID}' ,'waiting' ,CURDATE() )";

		if ($sqlconnection->query($addOrderQuery) === TRUE) {
				echo "inserted.";
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}
	}

?>