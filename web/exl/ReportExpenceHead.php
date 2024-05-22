<?php
// Connection 
include("connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$type = $_REQUEST['type'];
$e_id = $_REQUEST['e_id'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

$file_name = "Expence_List"; 
if($type == 'all' && $e_id == 'all'){
$user_query = "SELECT e.id, e.voucher, e.ex_date, a.e_name AS exby, e.type, q.ex_type AS head, e.amount, w.e_name AS entryby, e.check_date, e.check_note FROM expanse AS e
								LEFT JOIN emp_info AS a
								ON a.e_id = e.ex_by
								LEFT JOIN expanse_type AS q
								ON q.id = e.type
								LEFT JOIN emp_info AS w
								ON w.e_id = e.check_by
								WHERE e.ex_date BETWEEN '$f_date' AND '$t_date' AND e.status = '2' ORDER BY e.ex_date ASC";
}

if($type == 'all' && $e_id != 'all'){
$user_query = "SELECT e.id, e.voucher, e.ex_date, a.e_name AS exby, e.type, q.ex_type AS head, e.amount, w.e_name AS entryby, e.check_date, e.check_note FROM expanse AS e
								LEFT JOIN emp_info AS a
								ON a.e_id = e.ex_by
								LEFT JOIN expanse_type AS q
								ON q.id = e.type
								LEFT JOIN emp_info AS w
								ON w.e_id = e.check_by
								WHERE e.ex_date BETWEEN '$f_date' AND '$t_date' AND e.ex_by = '$e_id' AND e.status = '2' ORDER BY e.ex_date ASC";
	}
	
if($type != 'all' && $e_id == 'all'){
$user_query = "SELECT e.id, e.voucher, e.ex_date, a.e_name AS exby, e.type, q.ex_type AS head, e.amount, w.e_name AS entryby, e.check_date, e.check_note FROM expanse AS e
								LEFT JOIN emp_info AS a
								ON a.e_id = e.ex_by
								LEFT JOIN expanse_type AS q
								ON q.id = e.type
								LEFT JOIN emp_info AS w
								ON w.e_id = e.check_by
								WHERE e.ex_date BETWEEN '$f_date' AND '$t_date' AND e.type = '$type' AND e.status = '2' ORDER BY e.ex_date ASC";
	}
	
if($type != 'all' && $e_id != 'all'){
$user_query = "SELECT e.id, e.voucher, e.ex_date, a.e_name AS exby, e.type, q.ex_type AS head, e.amount, w.e_name AS entryby, e.check_date, e.check_note FROM expanse AS e
								LEFT JOIN emp_info AS a
								ON a.e_id = e.ex_by
								LEFT JOIN expanse_type AS q
								ON q.id = e.type
								LEFT JOIN emp_info AS w
								ON w.e_id = e.check_by
								WHERE e.ex_date BETWEEN '$f_date' AND '$t_date' AND e.type = '$type' AND e.ex_by = '$e_id' AND e.status = '2' ORDER BY e.ex_date ASC";
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