<?php
// Connection 
include("connection.php") ;
ini_alter('date.timezone','Asia/Almaty');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$way = $_REQUEST['way'];
$z_id = $_REQUEST['z_id'];
$e_id = $_REQUEST['e_id'];
$user_type = $_REQUEST['user_type'];
$box_id = $_REQUEST['box_id'];
$p_m = $_REQUEST['p_m'];
$con_sts = $_REQUEST['con_sts'];
$partial = $_REQUEST['partial'];
$query_date = date("Y-m-d");
$df_date = $_REQUEST['df_date'];
$dt_date = $_REQUEST['dt_date'];

$f_date = date('Y-m-01', strtotime($query_date));
$t_date = date('Y-m-t', strtotime($query_date));
$date_time = date("Y_m_d-H_i_s");

$file_name = "Due_Bills_".$date_time; 

if($way == 'macreseller'){
$sql = "SELECT t1.c_id AS PPPoE_User, t1.c_name AS Name, t1.b_name AS Zone, t1.p_name AS Package, t1.con_sts, t1.c_name, t1.note, t1.cell, t1.p_price, t2.dis, t2.bill, t3.bill_disc, t1.p_m, t3.pay FROM
								(
								SELECT c.c_id, c.c_name, c.con_sts, c.address, z.z_name, d.b_name, c.cell, c.p_id, p.p_price_reseller AS p_price, c.note, c.p_m, p.p_name FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z on z.z_id = c.z_id
								LEFT JOIN box AS d on d.box_id = c.box_id
								WHERE c.sts = 0 AND c.mac_user = '1'";  							
					if ($z_id != 'all') {
						$sql .= " AND c.z_id = '{$z_id}'";
					}
					if ($box_id != 'all'){
						$sql .= " AND c.box_id = '{$box_id}'";
					}
					if ($p_m != 'all') {
						$sql .= " AND c.p_m = '{$p_m}'";
					}
					$sql .= ")t1
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing_mac_client AS b
								WHERE MONTH(b.bill_date) = MONTH('$f_date') AND YEAR(b.bill_date) = YEAR('$f_date')
								GROUP BY b.c_id
								)t2
								ON t1.c_id = t2.c_id
								LEFT JOIN
								(
								SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment_mac_client AS p 
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date'
								GROUP BY p.c_id
								)t3
								ON t1.c_id = t3.c_id ORDER BY t1.con_sts";
}
else{
$sql = "SELECT t1.com_id AS Company_ID, t1.c_id AS Client_ID, t1.c_name AS Name, t1.address AS Address, t1.z_name AS Zone, t1.b_name AS Box, t1.cell AS Cell_No, t1.con_sts AS Connection_Status, t1.note, t1.p_name AS Package, t1.payment_deadline AS Payment_Deadline, t1.b_date AS Billing_Deadline, t1.p_price AS Price, IFNULL(t2.bill,0.00) - (IFNULL(t3.bill_disc,0.00)+IFNULL(t3.pay,0.00)) AS Total_Due FROM
(SELECT c.id, c.com_id, c.c_id, c.c_name, c.con_sts, c.address, z.z_name, c.cell, d.b_name, c.p_id, p.p_price, c.payment_deadline, c.b_date, c.note, c.p_m, p.p_name FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z on z.z_id = c.z_id
								LEFT JOIN box AS d on d.box_id = c.box_id
								WHERE c.sts = '0' AND c.mac_user != '1'";  							
					if ($z_id != 'all') {
						$sql .= " AND c.z_id = '{$z_id}'";
					}
					if ($p_m != 'all') {
						$sql .= " AND c.p_m = '{$p_m}'";
					}
					
					if ($user_type == 'billing'){
						$sql .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
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
								(SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b WHERE b.bill_date < '$t_date' GROUP BY b.c_id)t2
								ON t1.c_id = t2.c_id

								LEFT JOIN

								(SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p WHERE p.pay_date < '$t_date' GROUP BY p.c_id)t3
								ON t1.c_id = t3.c_id

								WHERE IFNULL(t2.bill,0.00) - (IFNULL(t3.bill_disc,0.00)+IFNULL(t3.pay,0.00)) > '0.99' ORDER BY t1.b_name ASC";
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