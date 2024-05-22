<?php
// Connection 
include("connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$con_sts = $_REQUEST['con_sts'];
$inactive_type = $_REQUEST['inactive_type'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

$file_name = "Diactivation_Clients"; 

if($inactive_type == 'all'){
$user_query = "SELECT s.update_date_time, c.com_id, c.c_id, c.c_name, z.z_name, c.cell, c.address, c.join_date, p.p_name, p.bandwith FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' GROUP BY s.c_id ORDER BY s.update_date DESC";
}
if($inactive_type == 'auto'){
$user_query = "SELECT s.update_date_time, c.com_id, c.c_id, c.c_name, z.z_name, c.cell, c.address, c.join_date, p.p_name, p.bandwith FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' AND s.update_by = 'Auto' GROUP BY s.c_id ORDER BY s.update_date DESC";
}
if($inactive_type == 'notauto'){
$user_query = "SELECT s.update_date_time, c.com_id, c.c_id, c.c_name, z.z_name, c.cell, c.address, c.join_date, p.p_name, p.bandwith FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' AND s.update_by != 'Auto' GROUP BY s.c_id ORDER BY s.update_date DESC";
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