<?php
	header("Content-Type: application/json; charset=UTF-8");
	/*$obj = json_decode($_GET["x"], false);

	$conn = new mysqli("myServer", "myUser", "myPassword", "Northwind");
	$result = $conn->query("SELECT name FROM ".$obj->$table." LIMIT ".$obj->$limit);
	$outp = array();
	$outp = $result->fetch_all(MYSQLI_ASSOC);
	*/
	$outp = array("name"=>"Jitendra Gupta","age"=>"35", "Designation"=>"Sr. System Analyst");
	echo "myFunc(".json_encode($outp).")";

?>	