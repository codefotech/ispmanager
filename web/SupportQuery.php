<?php
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

$sqlsdf = mysql_query("SELECT sms_msg FROM sms_msg WHERE id= '8'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

$mass = mysql_real_escape_string($massage);

$y = date("Y");
$m = date("m");
$dat = $y.$m;
		$sql = ("SELECT id FROM complain_master ORDER BY id DESC LIMIT 1");
		$query2 = mysql_query($sql);
		$row = mysql_fetch_assoc($query2);
		$old_id = $row['id'];
		if($old_id == ''){
			$new_id = $dat.'1';
		}
		else{
			$new = $old_id + 1;
			$new_id = $dat.$new;
		}
		
		if($new_id != ''){

			$query = "insert into complain_master (ticket_no, c_id, dept_id, sub, massage, entry_by, entry_date_time)
					  VALUES ('$new_id', '$c_id', '$dept_id', '$sub', '$mass', '$entry_by', '$entry_date_time')";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		if ($result)
			if ($way=='internal'){
		{
			header("location: SupportInternal");
		}
			}
		if ($way=='client'){
		{
			if($sentsms=='Yes'){
			
//SMS Start....
			$from_page = 'Add Ticket';
			$send_date = date("Y-m-d");
			$send_time = date("H:i:s");

			$sql330 = ("SELECT c.id, c.ticket_no, c.c_id, z.c_name, z.cell, d.dept_name, c.sub, c.massage FROM complain_master AS c
							LEFT JOIN department_info AS d
							ON d.dept_id = c.dept_id
							LEFT JOIN clients AS z
							ON z.c_id = c.c_id WHERE c.ticket_no = '$new_id'");
					
			$query330 = mysql_query($sql330);
			$row330 = mysql_fetch_assoc($query330);
			$ticket_noo= $row330['ticket_no'];
			$c_idd= $row330['c_id'];
			$dept_namee= $row330['dept_name'];
			$subb= $row330['sub'];
			$cell= $row330['cell'];
			$c_namee= $row330['c_name'];
			$massageee= $row330['massage'];

$replacements = array(
	'c_id' => $c_idd,
	'c_name' => $c_namee,
	'TicketNo' => $ticket_noo,
	'DepartmentTo' => $dept_namee,
	'SupportSubject' => $subb,
	'SupportMassage' => $massageee,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$sms_body = bind_to_template($replacements, $sms_msg);
$send_by = $entry_by;
include('include/smsapicore.php');

 if($result > '0') { ?>
			<html>
			<body>
				 <form action="Support" method="post" name="done">
				   <input type="hidden" name="sts" value="smssent">
				 </form>
				 <script language="javascript" type="text/javascript">
					document.done.submit();
				 </script>
				 <noscript><input type="submit" value="done"></noscript>
			</body>
			</html>
<?php } else{?>
			<html>
			<body>
				 <form action="Support" method="post" name="done">
				   <input type="hidden" name="sts" value="smsnotsent">
				 </form>
				 <script language="javascript" type="text/javascript">
					document.done.submit();
				 </script>
				 <noscript><input type="submit" value="done"></noscript>
			</body>
			</html>
	<?php	}
		}
		else{ ?>
			<html>
			<body>
				 <form action="Support" method="post" name="done">
				   <input type="hidden" name="sts" value="newticket">
				 </form>
				 <script language="javascript" type="text/javascript">
					document.done.submit();
				 </script>
				 <noscript><input type="submit" value="done"></noscript>
			</body>
			</html>
		<?php }
// SMS END....
		}

			}

			

mysql_close($con);

?>



