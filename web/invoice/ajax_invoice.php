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
	$query = "SELECT id AS productCode, i_name AS productName, i_des, i_unit, vat FROM invoice_item WHERE sts = '0' AND use_sts = '0' AND UPPER(i_name) LIKE '%".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['productCode'].'|'.$row['productName'].'|'.$row['i_des'].'|'.$row['i_unit'].'|'.$row['vat'];
		array_push($data, $name);
	}	
	echo json_encode($data);exit;
}


