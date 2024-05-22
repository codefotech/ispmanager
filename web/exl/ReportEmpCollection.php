<?php
// Connection 
include("connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$e_id = $_REQUEST['e_id'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

$file_name = "Employee_Collections"; 
if($e_id == 'all'){
$user_query = "SELECT p.pay_date AS Payment_date, c.com_id, c.c_id AS Client_id, c.address, c.cell, p.moneyreceiptno AS MR_No, b.bank_name AS Bank, SUM(p.pay_amount) AS Payment_Amount, SUM(p.bill_discount) AS Discount, e.e_name AS Entry_by, c.note
								FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
								LEFT JOIN bank AS b ON b.id = p.bank
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date' AND c.mac_user != '1'
								GROUP BY p.c_id ORDER BY c.address";
}

else{
$user_query = "SELECT p.pay_date AS Payment_date, c.com_id, c.c_id AS Client_id, c.address, c.cell, p.moneyreceiptno AS MR_No, b.bank_name AS Bank, SUM(p.pay_amount) AS Payment_Amount, SUM(p.bill_discount) AS Discount, e.e_name AS Entry_by, c.note
								FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
								LEFT JOIN bank AS b ON b.id = p.bank
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date' AND p.pay_ent_by = '$e_id' AND c.mac_user != '1'
								GROUP BY p.c_id ORDER BY c.address";
	}
	
//run mysql query and then count number of fields
$export = mysql_query ( $user_query ) 
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