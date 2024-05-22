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
	$query = "SELECT id AS productCode, pro_name AS productName, pro_details, unit, vat, sl_sts FROM product WHERE sts = '0' AND UPPER(pro_name) LIKE '%".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['productCode'].'|'.$row['productName'].'|'.$row['unit'].'|'.$row['vat'].'|'.$row['sl_sts'];
		array_push($data, $name);
	}	
	echo json_encode($data);exit;
}


