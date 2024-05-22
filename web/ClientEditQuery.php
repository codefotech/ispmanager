<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
include("mk_api.php");
extract($_POST);

$sqlc11 = mysql_query("SELECT mk_id, mac_user FROM clients WHERE c_id = '$c_id'");
$rowc11 = mysql_fetch_assoc($sqlc11);
$mk_idd = $rowc11['mk_id'];
$mac_userrrr = $rowc11['mac_user'];

$sqlq = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h, add_date_time, note FROM mk_con WHERE id = '$mk_idd'");
$row2 = mysql_fetch_assoc($sqlq);
$Pass= openssl_decrypt($row2['Pass'], $row2['e_Md'], $row2['secret_h']);

$API = new routeros_api();
$API->debug = false;

if($old_ip != $ip && $breseller == '1'){
	if ($API->connect($row2['ServerIP'], $row2['Username'], $Pass, $row2['Port'])) {
	 $arrID =	$API->comm("/queue/simple/getall", array(".proplist"=> ".id","?name" => $c_id,));
				$API->comm("/queue/simple/set", array(".id" => $arrID[0][".id"],"target" => $ip));
	}
}

if($ppoe_comment == '0' && $breseller == '0'){
$sqlc1 = mysql_query("SELECT b_name FROM box WHERE box_id = '$box_id'");
$rowc1 = mysql_fetch_assoc($sqlc1);
$bname = $rowc1['b_name'];

$sqlc1 = mysql_query("SELECT p_price FROM package WHERE p_id = '$p_id'");
$rowc1 = mysql_fetch_assoc($sqlc1);
$pprice = $rowc1['p_price'];

$billamount = ($pprice - $discount)+$extra_bill;

$comment = $c_name.'-'.$cell.'-'.$address.'-'.$bname.'-'.$join_date.'-'.$billamount.'TK-Last_Edit_by:'.$edit_by.'-'.$edit_date.'-'.$edit_time;

	if ($API->connect($row2['ServerIP'], $row2['Username'], $Pass, $row2['Port'])) {
	 $arrID =	$API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_id,));
				$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"comment" => $comment));
	}
}

$cellc = filter_var($cell, FILTER_SANITIZE_NUMBER_INT);
$cellc1 = filter_var($cell1, FILTER_SANITIZE_NUMBER_INT);
$cellc2 = filter_var(isset($_POST['cell2']) ? $_POST['cell2'] : '', FILTER_SANITIZE_NUMBER_INT);
$cellc3 = filter_var(isset($_POST['cell3']) ? $_POST['cell3'] : '', FILTER_SANITIZE_NUMBER_INT);
$cellc4 = filter_var(isset($_POST['cell4']) ? $_POST['cell4'] : '', FILTER_SANITIZE_NUMBER_INT);
$cable_stss = isset($_POST['cable_sts']) ? $_POST['cable_sts'] : '';
$agent_idd = isset($_POST['agent_id']) ? $_POST['agent_id'] : '';
$count_commissionn = isset($_POST['count_commission']) ? $_POST['count_commission'] : '';
$com_percentt = isset($_POST['com_percent']) ? $_POST['com_percent'] : '';

if($mac_userrrr == '0'){
	$querywwww="UPDATE clients SET mk_id = '$mk_id' WHERE c_id = '$c_id'";
	$resultww = mysql_query($querywwww) or die("inser_query failed: " . mysql_error() . "<br />");
}

		$query="UPDATE clients SET
				z_id = '$z_id',
				box_id = '$box_id',
				com_id = '$com_id',
				technician = '$technician',
				father_name = '$father_name',
				pop = '$pop',
				old_address = '$old_address',
				c_name = '$c_name',
				bill_man = '$bill_man',
				occupation = '$occupation',
				cell = '$cellc',
				cell1 = '$cellc1',
				cell2 = '$cellc2',
				cell3 = '$cellc3',
				cell4 = '$cellc4',
				email = '$email',
				thana = '$thana',
				connectivity_type = '$connectivity_type',
				ip = '$ip',
				mac = '$mac',
				con_type = '$con_type',
				req_cable = '$req_cable',
				cable_type = '$cable_type',
				cable_sts = '$cable_stss',
				nid = '$nid',
				p_m = '$p_m',
				signup_fee = '$signup_fee',
				discount = '$discount',
				extra_bill = '$extra_bill',
				note = '$note',
				join_date = '$join_date',
				address = '$address',
				edit_by = '$edit_by',
				edit_date = '$edit_date',
				edit_time = '$edit_time',
				payment_deadline = '$payment_deadline',
				termination_date = '$termination_date',
				latitude = '$latitude',
				longitude = '$longitude',
				b_date = '$b_date',
				onu_mac = '$onu_mac',
				flat_no = '$flat_no',
				house_no = '$house_no',
				road_no = '$road_no',
				edit_sts = '$edit_sts',
				com_percent = '$com_percentt',
				count_commission = '$count_commissionn',
				agent_id = '$agent_idd'

				WHERE c_id = '$c_id'";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
		if($cable_type == 'FIBER' && $diagram_way == '1'){
			$sqlc = mysql_query("SELECT c_id FROM network_tree WHERE c_id = '$c_id'");
			$rowc = mysql_fetch_assoc($sqlc);
			if($rowc['c_id'] == ''){
				$querytreew="INSERT INTO network_tree (parent_id, in_port, in_color, out_port, fiber_code, z_id, device_type, name, location, entry_by, entry_time, c_id, latitude, longitude, mk_id)
					VALUES ('$parent_id', '$in_port', '$in_color', '1', '$fiber_code', '$z_id', '4', '$c_id', '$address', '$entry_by', '$entry_date', '$c_id', '$latitude', '$longitude', '$mk_id')";
				$resulttree = mysql_query($querytreew) or die("inser_query failed: " . mysql_error() . "<br />");
			}
			else{
			$querytree ="UPDATE network_tree SET parent_id = '$parent_id', in_port='$in_port', in_color = '$in_color', fiber_code ='$fiber_code', z_id ='$z_id', location = '$address', latitude = '$latitude', longitude = '$longitude', mk_id = '$mk_id' WHERE c_id = '$c_id'";
			$resultsdfg = mysql_query($querytree) or die("inser_query failed: " . mysql_error() . "<br />");
			}
		}
		else{
			$querytree ="DELETE FROM network_tree WHERE c_id = '$c_id'";
			$resultsdfg = mysql_query($querytree) or die("inser_query failed: " . mysql_error() . "<br />");
		}
?>

<html>
	<body>
		<form action="Clients?id=all" method="post" name="ok">
			<input type="hidden" name="sts" value="edit">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
