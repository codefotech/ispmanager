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
	/*
	$query = "SELECT p.id, p.productCode, p.model_id, b.brand_name, p.productName, p.buyPrice, p.brand_id, IFNULL(s.totalstock,0) AS totalstock, IFNULL(d.totalsale,0) AS totalsale, (IFNULL(s.totalstock,0) - IFNULL(d.totalsale,0)) AS remaining FROM products AS p
												LEFT JOIN
												(SELECT productCode, SUM(quantity) AS totalstock FROM stock_details GROUP BY productCode)AS s
												ON s.productCode = p.id
												LEFT JOIN
												(SELECT productCode, SUM(quantity) AS totalsale FROM sales_details GROUP BY productCode)AS d
												ON d.productCode = p.id
												LEFT JOIN brand AS b
												ON b.brand_id = p.brand_id

												WHERE p.parts_sts = '0' AND IFNULL(s.totalstock,0) - IFNULL(d.totalsale,0) > '0' AND UPPER($type) LIKE '".strtoupper($name)."%' GROUP BY p.id";
	
	$query = "SELECT p.id, p.productCode, p.model_id, b.brand_name, p.productName, p.buyPrice FROM products AS p
			 LEFT JOIN brand AS b
			 ON b.brand_id = p.brand_id
			 WHERE p.parts_sts = 0 AND UPPER($type) LIKE '".strtoupper($name)."%'";
	*/		 
	$query = "SELECT t.id, t.productCode, t.model_id, t.brand_name, t.productName, t.buyPrice, t.brand_id, t.totalstock, t.totalsale, (t.totalstock - t.totalsale) AS remaining FROM
				(
				SELECT l.id, l.productCode, l.model_id, l.brand_name, l.productName, l.buyPrice, l.brand_id, IFNULL(l1.totalstock,0) AS totalstock, IFNULL(l2.totalsale,0) AS totalsale FROM
				(
				SELECT p.id, p.productCode, p.model_id, b.brand_name, p.productName, p.buyPrice, p.brand_id, p.parts_sts FROM products AS p
				LEFT JOIN brand AS b ON b.brand_id = p.brand_id
				)l
				LEFT JOIN
				(
				SELECT productCode, SUM(quantity) AS totalstock FROM stock_details GROUP BY productCode
				)l1
				ON l.id = l1.productCode
				LEFT JOIN
				(
				SELECT productCode, SUM(quantity) AS totalsale FROM sales_details GROUP BY productCode
				)l2
				ON l.id = l2.productCode
				WHERE l.parts_sts = 0
				)t
			 WHERE (t.totalstock - t.totalsale)>0 AND UPPER($type) LIKE '".strtoupper($name)."%'";
	
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['id'].' - '.$row['productCode'].'|'.$row['productName'].' - '.$row['model_id'].' - '.$row['brand_name'].' - '.$row['remaining'].'|'.$row['buyPrice'];
		array_push($data, $name);
	}	
	echo json_encode($data);exit;
}