<?php
/*
Site : http:www.smarttutorials.net
Author :muni
*/
require_once 'conn/config.php';
if(!empty($_POST['type'])){
	$type = $_POST['type'];
	$name = $_POST['name_startsWith'];
	//$query = "SELECT productCode, productName, buyPrice FROM products where quantityInStock !=0 and UPPER($type) LIKE '".strtoupper($name)."%'";
	$query = "SELECT id, pro_name, pro_details FROM products
	WHERE sts = 0 AND UPPER($type) LIKE '".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['id'].' - '.$row['pro_name'].'|'.$row['pro_details'];
		array_push($data, $name);
	}	
	echo json_encode($data);exit;
}


