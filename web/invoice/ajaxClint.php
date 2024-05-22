<?php
/*
Site : http:www.smarttutorials.net
Author :muni
*/
require_once 'config.php';
if(!empty($_POST['type'])){
	$type = $_POST['type'];
	$name = $_POST['Clint_name_startsWith'];
	//$query = "SELECT productCode, productName, buyPrice FROM products where quantityInStock !=0 and UPPER($type) LIKE '".strtoupper($name)."%'";
	$query = "SELECT * FROM clients WHERE clients_sts = 0 AND UPPER($type) LIKE '".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['clientId'].'|'.$row['clientName'].' - '.$row['clients_phone'].'|'.$row['clients_phone'].'|'.$row['clients_address'];
		array_push($data, $name);
	}	
	echo json_encode($data);exit;
}


