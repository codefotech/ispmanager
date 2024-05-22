<?php
// Connection 
include("connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

ini_alter('date.timezone','Asia/Almaty');
$emp_id = $_REQUEST['emp_id'];
$p_m = $_REQUEST['p_m'];
$con_sts = $_REQUEST['con_sts'];
$df_date = $_REQUEST['df_date'];
$dt_date = $_REQUEST['dt_date'];
$sts = $_REQUEST['sts'];

$f_date = date('Y-m-01', strtotime($query_date));
$t_date = date('Y-m-t', strtotime($query_date));
$query_date = date("Y-m-d");
$t_date = date('Y-m-t', strtotime($query_date));
$date_time = date("Y_m_d-H_i_s");

$file_name = "Due_Bills_".$date_time; 

		if($way == 'macreseller'){
$sql = "SELECT t1.id AS App_ID, t1.c_id AS PPPoE_User, t1.c_name AS Name, t1.address AS Address, t1.z_name AS Zone, t1.cell AS Cell_No, t1.con_sts AS Connection_Status, t1.note, t1.p_name AS Package, t1.p_price AS Price, IFNULL(t2.bill,0.00) - (IFNULL(t3.bill_disc,0.00)+IFNULL(t3.pay,0.00)) AS Total_Due FROM
(SELECT c.id, c.c_id, c.c_name, c.con_sts, c.address, z.z_name, c.cell, c.p_id, p.p_price_reseller AS p_price, c.note, c.p_m, p.p_name FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z on z.z_id = c.z_id
								WHERE c.sts = '0' AND c.mac_user = '1'";  							
					if ($emp_id != 'all') {
						$sql .= " AND z.emp_id = '{$emp_id}'";
					}
					if ($p_m != 'all') {
						$sql .= " AND c.p_m = '{$p_m}'";
					}
					$sql .= ")t1
								LEFT JOIN
								(SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing_mac_client AS b WHERE b.bill_date < '$t_date'	GROUP BY b.c_id)t2
								ON t1.c_id = t2.c_id

								LEFT JOIN

								(SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment_mac_client AS p WHERE p.pay_date < '$t_date'	GROUP BY p.c_id)t3
								ON t1.c_id = t3.c_id

								WHERE IFNULL(t2.bill,0.00) - (IFNULL(t3.bill_disc,0.00)+IFNULL(t3.pay,0.00)) > '0' ORDER BY t1.z_name ASC";
		}
		else{
$sql = "SELECT t1.id AS App_ID, t1.c_id AS PPPoE_User, t1.c_name AS Name, t1.address AS Address, t1.z_name AS Zone, t1.cell AS Cell_No, t1.con_sts AS Connection_Status, t1.note, t1.p_name AS Package, t1.p_price AS Price, IFNULL(t2.bill,0.00) - (IFNULL(t3.bill_disc,0.00)+IFNULL(t3.pay,0.00)) AS Total_Due FROM
(SELECT c.id, c.c_id, c.c_name, c.con_sts, c.address, z.z_name, c.cell, c.p_id, p.p_price, c.note, c.p_m, p.p_name FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z on z.z_id = c.z_id
								WHERE c.sts = '0' AND c.mac_user != '1'";  							
					if ($emp_id != 'all') {
						$sql .= " AND z.emp_id = '{$emp_id}'";
					}
					if ($p_m != 'all') {
						$sql .= " AND c.p_m = '{$p_m}'";
					}
					if ($con_sts != 'all') {
						$sql .= " AND c.con_sts = '{$con_sts}'";
					}
					if ($sts != 'all') {
						$sql .= " AND c.sts = '{$sts}'";
					}
					if ($df_date != 'all' && $dt_date != 'all'){
						$sql .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$dt_date}'";
					}
					if ($df_date != 'all' && $dt_date == 'all'){
						$sql .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$df_date}'";
					}
					if ($df_date == 'all' && $dt_date == 'all'){
						$sql .= "";
					}
					if ($df_date == 'all' && $dt_date != 'all'){
						$sql .= " AND c.payment_deadline BETWEEN '{$dt_date}' AND '{$dt_date}'";
					}
					$sql .= ")t1
								LEFT JOIN
								(SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b WHERE b.bill_date < '$t_date'	GROUP BY b.c_id)t2
								ON t1.c_id = t2.c_id

								LEFT JOIN

								(SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p WHERE p.pay_date < '$t_date'	GROUP BY p.c_id)t3
								ON t1.c_id = t3.c_id

								WHERE IFNULL(t2.bill,0.00) - (IFNULL(t3.bill_disc,0.00)+IFNULL(t3.pay,0.00)) > '0' ORDER BY t1.z_name ASC";
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