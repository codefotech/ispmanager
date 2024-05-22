<?php
include("conn/connection.php");
include('company_info.php');
ini_alter('date.timezone','Asia/Almaty');
$today_date = date('Y-m-d', time());
$today_time = date('H:i:s', time());
$today_date_time = date('Y-m-d H:i:s', time());
			$sql = mysql_query("SELECT c_id FROM clients WHERE mac_user = '1' AND MONTH(archived_date_time) != MONTH('$today_date_time') AND YEAR(archived_date_time) != YEAR('$today_date_time') ORDER BY z_id ASC");
								
	while( $row = mysql_fetch_assoc($sql) ){
		
	$c_idd = $row['c_id'];
	
		$sqlsdf = mysql_query("SELECT id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time, sts FROM billing_mac WHERE c_id = '$c_idd' AND archive_sts != '1' ORDER BY id ASC");
		while( $rowsm = mysql_fetch_assoc($sqlsdf) ){
			
		$old_id= $rowsm['id'];
		$old_z_id= $rowsm['z_id'];
		$old_p_id= $rowsm['p_id'];
		$old_start_date= $rowsm['start_date'];
		$old_start_time= $rowsm['start_time'];
		$old_end_date= $rowsm['end_date'];
		$old_days= $rowsm['days'];
		$old_p_price= $rowsm['p_price'];
		$old_bill_amount= $rowsm['bill_amount'];
		$old_entry_by= $rowsm['entry_by'];
		$old_entry_date= $rowsm['entry_date'];
		$old_entry_time= $rowsm['entry_time'];
		$old_sts= $rowsm['sts'];
				
		$query1 = "INSERT INTO billing_mac_archive (billing_mac_id, c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, sts, entry_by, entry_date, entry_time, archive_date, archive_time) VALUES 
		('$old_id', '$c_idd', '$old_z_id', '$old_p_id', '$old_start_date', '$old_start_time', '$old_end_date', '$old_days', '$old_p_price', '$old_bill_amount', '$old_sts', '$old_entry_by', '$old_entry_date', '$old_entry_time', '$today_date', '$today_time')";
			if (!mysql_query($query1))
					{
					die('Error: ' . mysql_error());
					}
		}
		
		$sqlsdfss = mysql_query("SELECT SUM(days) AS total_days, SUM(bill_amount) AS total_bill FROM billing_mac WHERE c_id = '$c_idd'");
		$rowsmss = mysql_fetch_assoc($sqlsdfss);
		$total_days= $rowsmss['total_days'];
		$total_bill= $rowsmss['total_bill'];
				
		$sqlfastdate = mysql_query("SELECT start_date, start_time FROM billing_mac WHERE c_id = '$c_idd' ORDER BY id ASC LIMIT 1");
		$rofastdate = mysql_fetch_assoc($sqlfastdate);
		$first_start_date= $rofastdate['start_date'];
		$first_start_time= $rofastdate['start_time'];
		
		$sqlenddate = mysql_query("SELECT end_date, z_id, p_id, p_price FROM billing_mac WHERE c_id = '$c_idd' ORDER BY id DESC LIMIT 1");
		$roenddate = mysql_fetch_assoc($sqlenddate);
		
		$end_end_date= $roenddate['end_date'];
		$end_z_id= $roenddate['z_id'];
		$end_p_id= $roenddate['p_id'];
		$end_p_price= $roenddate['p_price'];
		
		$query2bb11 = "DELETE FROM billing_mac WHERE c_id = '$c_idd'";
		if(!mysql_query($query2bb11))
							{
							die('Error: ' . mysql_error());
							}
							
		if($query2bb11){
		$query2bb = "INSERT INTO billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time, archive_sts) VALUES ('$c_idd', '$end_z_id', '$end_p_id', '$first_start_date', '$first_start_time', '$end_end_date', '$total_days', '$end_p_price', '$total_bill', 'Archived', '$today_date', '$today_time', '1')";
		if(!mysql_query($query2bb))
							{
							die('Error: ' . mysql_error());
							}
							
		$query2bbcc = "UPDATE clients SET archived_date_time = '$today_date_time' WHERE c_id = '$c_idd'";
		if(!mysql_query($query2bbcc))
							{
							die('Error: ' . mysql_error());
							}
		}
		
	}//Main Loop

?>

