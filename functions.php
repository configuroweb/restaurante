<?php

	//established the connection between databse
	require("dbconnection.php");

	session_start();
	
	//insert user defined function here
	// TODO - dynamic query
	function getNumRowsQuery($query) {
		global $sqlconnection;
		if ($result = $sqlconnection->query($query))
			return $result->num_rows;
		else
			echo "Something wrong the query!";
	}

	function getFetchAssocQuery($query) {
		global $sqlconnection;
		if ($result = $sqlconnection->query($query)) {
			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        		echo "\n", $row["itemID"], $row["menuID"], $row["menuItemName"], $row["price"];
    		}

    		//print_r($result);
			
			return ($result);
		}
		else
			echo "Something wrong the query!";
			echo $sqlconnection->error;
	}

	function getLastID($id,$table) {
		global $sqlconnection;

		$query = "SELECT MAX({$id}) AS {$id} from {$table} ";

		if ($result = $sqlconnection->query($query)) {
			
			$res = $result->fetch_array();

			//if currently no id in table
			if ($res[$id] == NULL)
				return 0;

			return $res[$id];
		}
		else {
			echo $sqlconnection->error;
			return null;
		}
	}

	function getCountID($idnum,$id,$table) {
		global $sqlconnection;

		$query = "SELECT COUNT({$id}) AS {$id} from {$table} WHERE {$id}={$idnum}";

		if ($result = $sqlconnection->query($query)) {
			
			$res = $result->fetch_array();

			//if currently no id in table
			if ($res[$id] == NULL)
				return 0;

			return $res[$id];
		}
		else {
			echo $sqlconnection->error;
			return null;
		}
	}

	function getSalesTotal($orderID) {
		global $sqlconnection;
		$total = null;

		$query = "SELECT total FROM tbl_order WHERE orderID = ".$orderID;

		if ($result = $sqlconnection->query($query)) {
		
			if ($res = $result->fetch_array()) {
				$total = $res[0];
				return $total;
			}

			return $total;
		}

		else {

			echo $sqlconnection->error;
			return null;

		}
	}

	function getSalesGrandTotal($duration) {
		global $sqlconnection;
		$total = 0;

		if ($duration == "ALLTIME") {
			$query = "
					SELECT SUM(total) as grandtotal
					FROM tbl_order
					";
		}

		else if ($duration == ("DAY" || "MONTH" || "WEEK")) {

			$query = "
					SELECT SUM(total) as grandtotal
					FROM tbl_order

					WHERE order_date > DATE_SUB(NOW(), INTERVAL 1 ".$duration.")
					";
		}

		else 
			return null;

		if ($result = $sqlconnection->query($query)) {
		
			while ($res = $result->fetch_array(MYSQLI_ASSOC)) {
				$total+=$res['grandtotal'];
			}

			return $total;
		}

		else {

			echo $sqlconnection->error;
			return null;

		}
	}

	function updateTotal($orderID) {
		global $sqlconnection;

		$query = "
			UPDATE tbl_order o
			INNER JOIN (
			    SELECT SUM(OD.quantity*mi.price) AS total
			        FROM tbl_order O
			        LEFT JOIN tbl_orderdetail OD
			        ON O.orderID = OD.orderID
			        LEFT JOIN tbl_menuitem MI
			        ON OD.itemID = MI.itemID
			        LEFT JOIN tbl_menu M
			        ON MI.menuID = M.menuID
			        
			        WHERE o.orderID = ".$orderID."
			) x
			SET o.total = x.total
			WHERE o.orderID = ".$orderID."
		";

		if ($sqlconnection->query($query) === TRUE) {
				echo "updated.";
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}

	}

?>