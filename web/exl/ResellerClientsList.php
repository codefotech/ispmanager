<?php
// Connection 
include("connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$z_id = $_REQUEST['z_id'];
//$sts = $_REQUEST['sts'];
//$f_date = $_REQUEST['f_date'];
//$t_date = $_REQUEST['t_date'];


$file_name = "Reseller_Clients_List"; 
if($z_id == 'allzone'){
	$user_query = "SELECT c.com_id, c.c_id, l.pw, c.c_name, c.cell, c.cell1, c.email, c.address, c.join_date, c.p_id, c.nid, c.note, c.con_sts, c.com_id FROM `clients` AS c
				LEFT JOIN login AS l ON l.user_id = c.c_id
				WHERE mac_user = '1' AND sts = '0'";
}

if($z_id != 'allzone'){
	$user_query = "SELECT c.com_id, c.c_id, l.pw, c.c_name, c.cell, c.cell1, c.email, c.address, c.join_date, c.p_id, c.nid, c.note, c.con_sts, c.com_id FROM `clients` AS c
				LEFT JOIN login AS l ON l.user_id = c.c_id
				WHERE c.z_id = '$z_id' AND mac_user = '1' AND sts = '0'";
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