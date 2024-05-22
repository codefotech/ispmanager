<?php
// Connection 
include("connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$z_id = $_REQUEST['z_id'];
$sts = $_REQUEST['sts'];
//$f_date = $_REQUEST['f_date'];
//$t_date = $_REQUEST['t_date'];


$file_name = "BTRC_Clients_List"; 
if($sts == 'all' && $z_id == 'allzone'){
$user_query = "SELECT c.con_type AS client_type, 'Wired' AS connection_type, c.c_name AS client_name, 'NOC' AS bandwidth_distribution_point, c.connectivity_type AS connectivity_type, c.join_date AS activation_date, CONVERT(SUBSTRING_INDEX(IFNULL(p.bandwith,c.raw_download),'-',-1),UNSIGNED INTEGER) AS bandwidth_allocation, c.c_id AS allocated_ip, d.name AS division, t.name AS district, c.thana AS thana, c.address AS address, c.cell AS client_mobile, c.email AS client_email, ((p.p_price - c.discount)+c.extra_bill) AS selling_price_bdt_excluding_vat FROM clients AS c
							LEFT JOIN package AS p ON p.p_id = c.p_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN login AS l ON l.e_id = c.c_id
							LEFT JOIN app_config AS a ON a.id != c.c_id
							LEFT JOIN divisions AS d ON d.id = a.division_id
                            LEFT JOIN districts AS t ON t.id = a.district_id
							WHERE c.sts = '0' AND ((p.p_price - c.discount)+c.extra_bill) > '0' AND c.breseller = '0' ORDER BY c.join_date ASC";
}

	if($sts == 'all' && $z_id != 'allzone'){
$user_query = "SELECT c.con_type AS client_type, 'Wired' AS connection_type, c.c_name AS client_name, 'NOC' AS bandwidth_distribution_point, c.connectivity_type AS connectivity_type, c.join_date AS activation_date, CONVERT(SUBSTRING_INDEX(IFNULL(p.bandwith,c.raw_download),'-',-1),UNSIGNED INTEGER) AS bandwidth_allocation, c.c_id AS allocated_ip, d.name AS division, t.name AS district, c.thana AS thana, c.address AS address, c.cell AS client_mobile, c.email AS client_email, ((p.p_price - c.discount)+c.extra_bill) AS selling_price_bdt_excluding_vat FROM clients AS c
							LEFT JOIN package AS p ON p.p_id = c.p_id
							LEFT JOIN zone AS z ON z.z_id = c.z_id
							LEFT JOIN login AS l ON l.e_id = c.c_id
							LEFT JOIN app_config AS a ON a.id != c.c_id
							LEFT JOIN divisions AS d ON d.id = a.division_id
                            LEFT JOIN districts AS t ON t.id = a.district_id
							WHERE c.z_id = '$z_id' AND ((p.p_price - c.discount)+c.extra_bill) > '0' AND c.sts = '0' AND c.breseller = '0' ORDER BY c.join_date ASC";
	}
	
	if($sts == 'active' && $z_id != 'allzone'){
$user_query = "SELECT c.con_type AS client_type, 'Wired' AS connection_type, c.c_name AS client_name, 'NOC' AS bandwidth_distribution_point, c.connectivity_type AS connectivity_type, c.join_date AS activation_date, CONVERT(SUBSTRING_INDEX(IFNULL(p.bandwith,c.raw_download),'-',-1),UNSIGNED INTEGER) AS bandwidth_allocation, c.c_id AS allocated_ip, d.name AS division, t.name AS district, c.thana AS thana, c.address AS address, c.cell AS client_mobile, c.email AS client_email, ((p.p_price - c.discount)+c.extra_bill) AS selling_price_bdt_excluding_vat FROM clients AS c
							LEFT JOIN package AS p ON p.p_id = c.p_id
							LEFT JOIN zone AS z ON z.z_id = c.z_id
							LEFT JOIN login AS l ON l.e_id = c.c_id
							LEFT JOIN app_config AS a ON a.id != c.c_id
							LEFT JOIN divisions AS d ON d.id = a.division_id
                            LEFT JOIN districts AS t ON t.id = a.district_id
							WHERE z.z_id = '$z_id' AND ((p.p_price - c.discount)+c.extra_bill) > '0' AND c.con_sts = 'Active' AND c.sts = '0' AND c.breseller = '0' ORDER BY c.join_date ASC";
	}
	
	if($sts == 'inactive' && $z_id != 'allzone'){
$user_query = "SELECT c.con_type AS client_type, 'Wired' AS connection_type, c.c_name AS client_name, 'NOC' AS bandwidth_distribution_point, c.connectivity_type AS connectivity_type, c.join_date AS activation_date, CONVERT(SUBSTRING_INDEX(IFNULL(p.bandwith,c.raw_download),'-',-1),UNSIGNED INTEGER) AS bandwidth_allocation, c.c_id AS allocated_ip, d.name AS division, t.name AS district, c.thana AS thana, c.address AS address, c.cell AS client_mobile, c.email AS client_email, ((p.p_price - c.discount)+c.extra_bill) AS selling_price_bdt_excluding_vat FROM clients AS c
							LEFT JOIN package AS p ON p.p_id = c.p_id LEFT JOIN zone AS z
							ON z.z_id = c.z_id LEFT JOIN login AS l ON l.e_id = c.c_id
							LEFT JOIN app_config AS a ON a.id != c.c_id
							LEFT JOIN divisions AS d ON d.id = a.division_id
                            LEFT JOIN districts AS t ON t.id = a.district_id
							WHERE z.z_id = '$z_id' AND ((p.p_price - c.discount)+c.extra_bill) > '0' AND c.con_sts = 'Inactive' AND c.sts = '0' AND c.breseller = '0' ORDER BY c.join_date ASC";
	}
	
	if($sts == 'active' && $z_id == 'allzone'){
$user_query = "SELECT c.con_type AS client_type, 'Wired' AS connection_type, c.c_name AS client_name, 'NOC' AS bandwidth_distribution_point, c.connectivity_type AS connectivity_type, c.join_date AS activation_date, CONVERT(SUBSTRING_INDEX(IFNULL(p.bandwith,c.raw_download),'-',-1),UNSIGNED INTEGER) AS bandwidth_allocation, c.c_id AS allocated_ip, d.name AS division, t.name AS district, c.thana AS thana, c.address AS address, c.cell AS client_mobile, c.email AS client_email, ((p.p_price - c.discount)+c.extra_bill) AS selling_price_bdt_excluding_vat FROM clients AS c
							LEFT JOIN package AS p ON p.p_id = c.p_id
							LEFT JOIN zone AS z ON z.z_id = c.z_id
							LEFT JOIN login AS l ON l.e_id = c.c_id
							LEFT JOIN app_config AS a ON a.id != c.c_id
							LEFT JOIN divisions AS d ON d.id = a.division_id
                            LEFT JOIN districts AS t ON t.id = a.district_id
							WHERE c.con_sts = 'active' AND ((p.p_price - c.discount)+c.extra_bill) > '0' AND c.sts = '0' AND c.breseller = '0' ORDER BY c.join_date ASC";
	}
	
	if($sts == 'inactive' && $z_id == 'allzone'){
$user_query = "SELECT c.con_type AS client_type, 'Wired' AS connection_type, c.c_name AS client_name, 'NOC' AS bandwidth_distribution_point, c.connectivity_type AS connectivity_type, c.join_date AS activation_date, CONVERT(SUBSTRING_INDEX(IFNULL(p.bandwith,c.raw_download),'-',-1),UNSIGNED INTEGER) AS bandwidth_allocation, c.c_id AS allocated_ip, d.name AS division, t.name AS district, c.thana AS thana, c.address AS address, c.cell AS client_mobile, c.email AS client_email, ((p.p_price - c.discount)+c.extra_bill) AS selling_price_bdt_excluding_vat FROM clients AS c
							LEFT JOIN package AS p ON p.p_id = c.p_id
							LEFT JOIN zone AS z ON z.z_id = c.z_id
							LEFT JOIN login AS l ON l.e_id = c.c_id
							LEFT JOIN app_config AS a ON a.id != c.c_id
							LEFT JOIN divisions AS d ON d.id = a.division_id
                            LEFT JOIN districts AS t ON t.id = a.district_id
							WHERE c.con_sts = 'inactive' AND ((p.p_price - c.discount)+c.extra_bill) > '0' AND c.sts = '0' AND c.breseller = '0' ORDER BY c.join_date ASC";
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
header("Content-disposition: xls" . date("Y-m-d") . ".xls");
header( "Content-disposition: filename=".$file_name.".xls");
print "\xEF\xBB\xBF";
print "$header\n$data";
exit;
?>