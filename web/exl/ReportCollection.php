<?php
// Connection 
include("connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$z_id = $_REQUEST['z_id'];
$e_id = $_REQUEST['e_id'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];
$way = $_REQUEST['way'];
$payment_type = $_REQUEST['payment_type'];
$box_id = $_REQUEST['box_id'];
$user_type = $_REQUEST['user_type'];

$file_name = "Collections_".$f_date.'_to_'.$t_date.'_'.$payment_type; 

if($way == 'none'){
				$sql = "SELECT p.pay_date, c.c_id AS ClientID, c.com_id AS ConpanyID, c.c_name AS Client_Name, c.cell, c.address, z.z_name AS ZoneName, b.id AS b_id, b.bank_name, pk.p_price, p.moneyreceiptno, p.sender_no, p.trxid, (case when (p.payment_type = '2') THEN 'Webhook' ELSE p.pay_mode END) AS pay_mode, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc, p.pay_ent_by, e.e_name AS EntryBy, c.note
								FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id 
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
								LEFT JOIN bank AS b ON b.id = p.bank
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date' AND c.mac_user = '0'";
				if ($z_id != 'all'){
					$sql .= " AND c.z_id = '{$z_id}'";
				}
				if ($user_type == 'billing'){
					$sql .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
				}
				if ($payment_type != 'all'){
					if ($payment_type == 'CASH'){
						$sql .= " AND p.pay_mode = '{$payment_type}'";
					}
					else{
						$sql .= " AND p.pay_mode != 'CASH'";
					}
				}
				$sql .= " GROUP BY p.c_id ORDER BY p.pay_date_time DESC";
}
else{
		$sql = "SELECT DATE_FORMAT(p.pay_date, '%d-%m-%Y') AS pay_date, c.com_id, c.c_id, p.moneyreceiptno, c.address, c.cell, pk.p_price_reseller AS p_price, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc, p.pay_ent_by, e.e_name, c.note, p.pay_mode
								FROM payment_mac_client AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date' AND c.z_id = '$z_id' AND c.mac_user = '1'";

					if($box_id != 'all'){
						$sql .= " AND c.box_id = '{$box_id}'";
					}
					if($payment_type != 'all'){
						if ($payment_type == 'CASH'){
							$sql .= " AND p.pay_mode = 'CASH'";
						}
						else{
							$sql .= " AND p.pay_mode != 'CASH'";
						}
						
					}
						$sql .= " GROUP BY p.c_id ORDER BY p.pay_date";  
}

	
//run mysql query and then count number of fields
$export = mysql_query ( $sql ) 
       or die ( "Sql error : " . mysql_error( ) );
$fields = mysql_num_fields ( $export );

//create csv header row, to contain table headers 
//with database field names
for ( $i = 0; $i < $fields; $i++ ) {
	$header .= mysql_field_name( $export , $i ) . ",";
}

//this is where most of the work is done. 
//Loop through the query results, and create 
//a row for each
while( $row = mysql_fetch_row( $export ) ) {
	$line = '';
	//for each field in the row
	foreach( $row as $value ) {
		//if null, create blank field
		if ( ( !isset( $value ) ) || ( $value == "" ) ){
			$value = ",";
		}
		//else, assign field value to our data
		else {
			$value = str_replace( '"' , '""' , $value );
			$value = '"' . $value . '"' . ",";
		}
		//add this field value to our row
		$line .= $value;
	}
	//trim whitespace from each row
	$data .= trim( $line ) . "\n";
}
//remove all carriage returns from the data
$data = str_replace( "\r" , "" , $data );


//create a file and send to browser for user to download
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$file_name.".csv");
print "\xEF\xBB\xBF";
print "$header\n$data";
exit;
?>