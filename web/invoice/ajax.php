<?php
/*
Site : http:www.smarttutorials.net
Author :muni
*/
require_once 'config.php';
if(!empty($_POST['type'])){
	$type = $_POST['type'];
	$name = $_POST['name_startsWith'];
	//$query = "SELECT productCode, productName, buyPrice FROM products where quantityInStock !=0 and UPPER($type) LIKE '".strtoupper($name)."%'";
	$query = "SELECT p.id, p.productCode, p.model_id, b.brand_name, productName, buyPrice FROM products AS p
	LEFT JOIN brand AS b
	ON b.brand_id = p.brand_id
	WHERE p.parts_sts = 0 AND UPPER($type) LIKE '".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['id'].' - '.$row['productCode'].'|'.$row['productName'].' - '.$row['model_id'].' - '.$row['brand_name'].'|'.$row['buyPrice'];
		array_push($data, $name);
	}	
	echo json_encode($data);exit;
}


