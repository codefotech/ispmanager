<?php
$titel = "Traffic";
$Traffic = 'active';
$_SESSION['module_name'] = $Traffic;
include("conn/connection.php") ;
include('include/hader.php');
date_default_timezone_set('Etc/GMT-6');
$type = isset($_GET['id']) ? $_GET['id']  : '';

extract($_POST); 
$dateTime = date('Y-m-d', time());
$dateTimedd = date('Y-m-01', time());

if(empty($_POST['bill_month'])){
$todaydate = date('Y-m-d', time());
$thismonth = date('F-Y', time());
$t_edate = date('Y-m-01', time());
$f_edate = date('Y-m-d', time());
}
else{
$todaydate = $bill_month;
$yrdata= strtotime($bill_month);
$thismonth = date('F-Y', $yrdata);
$t_edate = date('Y-m-01', strtotime($bill_month));
$f_edate = date('Y-m-t', strtotime($bill_month));
}

if($f_date == '' || $t_date == ''){
$f_date = date("Y-m-01");
$t_date = date("Y-m-d");
}

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];

$access = mysql_query("SELECT * FROM module WHERE module_name = 'Traffic' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '11' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

								if($type == 'search' && in_array(138, $access_arry)){
									$ziddd = $_POST['z_id'];
									$p_mmmm = $_POST['p_m'];
									$stsssss = $_POST['sts'];
									$constsss = $_POST['con_sts'];
									$df_dateeee = $_POST['df_date'];
									$dt_dateeee = $_POST['dt_date'];
										$sqlww = "SELECT t1.id, t1.c_id, t1.com_id, t1.c_name, t1.payment_deadline, t1.mk_name, t1.b_date, t1.address, t1.raw_download, t1.breseller, t1.mac_user, t1.raw_upload, t1.youtube_bandwidth, t1.total_bandwidth, t1.bandwidth_price, t1.youtube_price, t1.total_price, t1.join_date, t1.z_name, t1.p_name, t1.discount, t1.extra_bill, t1.con_sts, t1.note, t1.cell, t1.p_price, t2.dis, t2.bill, t1.note_auto, IFNULL(t3.bill_disc, 0) AS bill_disc, t1.p_m, IFNULL(t3.pay, 0) AS pay, (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) AS payable FROM
												(
												SELECT c.id, c.c_id, c.com_id, c.c_name, c.payment_deadline, m.Name AS mk_name, c.b_date, c.con_sts, c.address, c.raw_download, c.breseller, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, IFNULL(c.discount, 0.00) AS discount, IFNULL(c.extra_bill, 0.00) AS extra_bill, z.z_name, c.cell, c.email, c.p_id, p.p_price, c.note, c.p_m, p.p_name, c.mac_user, c.note_auto FROM clients AS c 
												LEFT JOIN package AS p ON c.p_id = p.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id WHERE c.mac_user = '0' AND c.sts = '0'";  							
									if ($ziddd != 'all') {
										$sqlww .= " AND c.z_id = '{$ziddd}'";
									}
									if ($p_mmmm != 'all') {
										$sqlww .= " AND c.p_m = '{$p_mmmm}'";
									}
									if ($stsssss != 'all') {
										$sqlww .= " AND c.sts = '{$stsssss}'";
									}
									if ($constsss != 'all') {
										$sqlww .= " AND c.con_sts = '{$constsss}'";
									}
									if ($df_dateeee != 'all' && $dt_dateeee != 'all'){
										$sqlww .= " AND c.payment_deadline BETWEEN '{$df_dateeee}' AND '{$dt_dateeee}'";
									}
									if ($df_dateeee != 'all' && $dt_dateeee == 'all'){
										$sqlww .= " AND c.payment_deadline BETWEEN '{$df_dateeee}' AND '{$df_dateeee}'";
									}
									if ($df_dateeee == 'all' && $dt_dateeee == 'all'){
										$sqlww .= "";
									}
									if ($df_dateeee == 'all' && $dt_dateeee != 'all'){
										$sqlww .= " AND c.payment_deadline BETWEEN '{$dt_dateeee}' AND '{$dt_dateeee}'";
									}
										$sqlww .= ")t1
												LEFT JOIN
												(
												SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
												GROUP BY b.c_id
												)t2
												ON t1.c_id = t2.c_id
												LEFT JOIN
												(
												SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p 											
												GROUP BY p.c_id
												)t3
												ON t1.c_id = t3.c_id"; 
									if ($partial != 'all'){
										if($partial != '1'){
											$sqlww .= " LEFT JOIN
												(
												SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p WHERE MONTH(p.pay_date) = MONTH('$dateTimedd') AND YEAR(p.pay_date) = YEAR('$dateTimedd')				
												GROUP BY p.c_id
												)t4
												ON t1.c_id = t4.c_id
                                                WHERE IFNULL(t4.pay, 0)+IFNULL(t4.bill_disc, 0) = '0.00' AND (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
										}
										else{
											$sqlww .= " LEFT JOIN
												(
												SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p WHERE MONTH(p.pay_date) = MONTH('$dateTimedd') AND YEAR(p.pay_date) = YEAR('$dateTimedd')				
												GROUP BY p.c_id
												)t4
												ON t1.c_id = t4.c_id
                                                WHERE IFNULL(t4.pay, 0)+IFNULL(t4.bill_disc, 0) != '0.00' AND (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
										}
									}
									else{
											$sqlww .= " WHERE (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
										}
											$sqlww .= " ORDER BY t1.id DESC";
										
										$sql = mysql_query($sqlww);
										
									$totallbills = mysql_num_rows($sql);
									
									$tit = "<div class='box-header'>
												<div class='hil'> Total Clients: <i style='color: #e3052e'>{$totallbills}</i></div> 
											</div>";
								}

							
if($user_type == 'mreseller'){
	$result1=mysql_query("SELECT box_id AS z_id, b_name AS z_name FROM box WHERE sts = '0' AND z_id = '$macz_id'");
}
else{
	if($user_type == 'billing'){
	$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name");
	$resultedfg=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name");
	}else{
	$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
	$resultedfg=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
	}
if($user_type == 'billing'){
$queryff="SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name";
}
else{
if($search_with_reseller_client == '1'){
$queryff="SELECT * FROM zone WHERE status = '0' order by z_name";
}
else{
$queryff="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
}
}
$resultff=mysql_query($queryff);
}


if(!empty($_POST['bill_month']) || empty($_POST['bill_month'])){
$queryddga = mysql_query("SELECT CONCAT(l.z_name,' - ',l.z_bn_name) AS item, (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) AS tot  FROM
								(
								SELECT z.z_id, z.z_name, z.z_bn_name, SUM(b.bill_amount) AS TotalBill, SUM(b.discount) AS TotalDiscount FROM billing AS b 
								LEFT JOIN clients AS c ON c.c_id = b.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
								WHERE b.bill_date BETWEEN '$t_edate' AND '$f_edate'
								GROUP BY c.z_id
								)l
								LEFT JOIN
								(
								SELECT z.z_id, z.z_name, SUM(p.pay_amount) AS TotalBills, SUM(p.bill_discount) AS TotalDiscount1 FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
								WHERE p.pay_date BETWEEN '$t_edate' AND '$f_edate'
								GROUP BY c.z_id
								)t
								ON l.z_id = t.z_id WHERE (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) >= '0'");
		$tnamee = 'Due Bills Summary [All Zone]';
		
$myurl1[]="['item','tot']";
while($q=mysql_fetch_assoc($queryddga)){
	
	$Item = $q['item'];
	$Total = $q['tot'];
	$myurl1[]="['".$Item."',".$Total."]";
}}
	
if(empty($_POST['bill_month']) || $bill_month == $dateTimedd){
$queryyutyu = mysql_query("SELECT DATE_FORMAT(b.bill_date, '%b, %Y') AS datemonth, (IFNULL(t2.invo_bill_amount,'0') + IFNULL(SUM(b.bill_amount), 0.00)) AS billamount, IFNULL(t1.payment_amount, 0.00) AS payment_amount, (IFNULL(t1.discount, 0.00) + IFNULL(SUM(b.discount), 0.00)) AS discount, IFNULL(t1.discount, 0.00) AS payment_discount FROM billing AS b
                            LEFT JOIN 
							(SELECT c_id, pay_date AS date, IFNULL(SUM(pay_amount), 0.00) AS payment_amount, IFNULL(SUM(bill_discount), 0.00) AS discount FROM payment
							WHERE pay_date >= DATE_SUB(DATE_ADD(subdate(curdate(), (day(curdate())-1)), INTERVAL 1 MONTH),INTERVAL 12 MONTH)  GROUP BY MONTH(pay_date), YEAR(pay_date)
							)t1
							ON MONTH(b.bill_date) = MONTH(t1.date)
                            LEFT JOIN 
							(SELECT invoice_date, IFNULL(sum(total_price), 0.00) AS invo_bill_amount FROM `billing_invoice`
							WHERE `sts` = '0' AND invoice_date >= DATE_SUB(DATE_ADD(subdate(curdate(), (day(curdate())-1)), INTERVAL 1 MONTH),INTERVAL 12 MONTH)  GROUP BY MONTH(invoice_date), YEAR(invoice_date)
							)t2
							ON MONTH(b.bill_date) = MONTH(t2.invoice_date)
							WHERE b.bill_date >= DATE_SUB(DATE_ADD(subdate(curdate(), (day(curdate())-1)), INTERVAL 1 MONTH),INTERVAL 12 MONTH) GROUP BY MONTH(b.bill_date), YEAR(b.bill_date) ORDER BY b.bill_date ASC");

$myurl[]="['datemonth', 'Bill', 'Collection', 'Discount']";
while($r=mysql_fetch_assoc($queryyutyu)){
	
	$datemonth = $r['datemonth'];
	$billamount = $r['billamount'];
	$payment_amount = $r['payment_amount'];
	$discount = $r['discount'];
//	$payment_discount = $r['payment_discount'];
	$myurl[]="['".$datemonth."', ".$billamount.", ".$payment_amount.", ".$discount."]";
}
$tname = "Monthly Bills, Collections, Bill Discount & Payment Discount";
$tname1 = "Last 11 Months";
}
else{
	$queryyutyu = mysql_query("SELECT z.z_id, z.z_name, IFNULL(SUM(t1.bill_amount), 0.00) AS billamounts, IFNULL(SUM(t2.pay_amount), 0.00) AS totalpaid, (IFNULL(SUM(t1.discount), 0.00) + IFNULL(SUM(t2.bill_discount), 0.00)) AS totaldiscount FROM zone AS z
											LEFT JOIN (SELECT c_id, z_id FROM clients)c1
											ON z.z_id = c1.z_id

											LEFT JOIN (SELECT b.c_id, b.bill_date, b.bill_amount, b.discount FROM billing AS b
											LEFT JOIN clients AS c ON c.c_id = b.c_id WHERE MONTH(b.bill_date) = MONTH('$todaydate') AND YEAR(b.bill_date) = YEAR('$todaydate')
											)t1
											ON t1.c_id = c1.c_id

											LEFT JOIN (SELECT p.c_id, p.pay_date, p.pay_amount, p.bill_discount FROM payment AS p
											LEFT JOIN clients AS c ON c.c_id = p.c_id WHERE MONTH(p.pay_date) = MONTH('$todaydate') AND YEAR(p.pay_date) = YEAR('$todaydate')
											)t2
											ON t2.c_id = c1.c_id
											WHERE z.e_id = '' AND z.status = '0' GROUP BY c1.z_id ORDER BY z.z_id ASC");

$myurl[]="['datemonth', 'Bill', 'Collection', 'Discount']";
while($r=mysql_fetch_assoc($queryyutyu)){
	
	$datemonth = $r['z_name'];
	$billamount = $r['billamounts'];
	$payment_amount = $r['totalpaid'];
	$discount = $r['totaldiscount'];
//	$payment_discount = $r['payment_discount'];
	$myurl[]="['".$datemonth."', ".$billamount.", ".$payment_amount.", ".$discount."]";
}
$tname = "All Zone Bills, Collections & Discount in ".$thismonth;
$tname1 = "[".$thismonth."]";
}

$sql30 = mysql_query("SELECT a.dat2ss, SUM(a.tx_byte) AS tx_byte, SUM(a.rx_byte) AS rx_byte, SUM(a.session_count) AS session_count FROM (SELECT session_date, DATE_FORMAT(date_time,'%Y, %m, %d, %H') AS dat2ss, (sum(tx_byte)/1000000000) AS tx_byte, (sum(rx_byte)/1000000000) AS rx_byte, COUNT(session_id) AS session_count FROM `client_bandwidth` GROUP BY session_time,session_date ORDER BY DATE_FORMAT(date_time,'%Y, %m, %d, %H, %i') ASC) AS a
						WHERE a.session_date BETWEEN '$f_date' AND DATE ( NOW() ) GROUP BY a.dat2ss ORDER BY a.dat2ss ASC");

while($r30=mysql_fetch_assoc($sql30)){
	$myurl30[]="[new Date(".$r30['dat2ss']."), ".$r30['tx_byte'].", ".$r30['rx_byte']."]";
}
$grptitel = '..::Collection Vs Discount [180 Days]::..';


?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
<script type="text/javascript">
google.charts.load('current', {'packages':['annotationchart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Download(GB)');
        data.addColumn('number', 'Upload(GB)');
        data.addRows([
		<?php echo(implode(",",$myurl30));?>
		]);
        var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div38'));
        var options = {
          displayAnnotations: true,
		  chart: {
            vAxis: {
              direction: 1
            }
          },
          range: {
            ui: {
              chartOptions: {
              vAxis: { direction: 1 }
              }
            }
          },
          displayAnnotationsFilter: true,
          thickness: 2,
          max: 100,
          min: 0
        };
        chart.draw(data, options);
      }
</script>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal11">
	<div id='Pointdiv2'></div>
</div>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" target="_blank" action="<?php if($user_type == 'mreseller'){echo 'fpdf/BillsPrintMac';} else{echo 'fpdf/BillsPrint';}?>">
	<?php if($user_type == 'mreseller'){ ?><input type="hidden" name="resellerzone" value="<?php echo $macz_id;?>" /><?php } ?>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Print Invoice</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Zone</div>
							<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select" style="width:250px;">
									<option value="all"> All Zone </option>
										<?php while ($row=mysql_fetch_array($result1)) { ?>
									<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?></option>
										<?php } ?>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Payment Method</div>
							<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:250px;">
											<option value="">All Payment Method</option>
											<option value="Cash">Cash</option>
											<option value="Home Cash">Cash from Home</option>
											<option value="Office">Office</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Clients Status</div>
							<select class="select-ext-large chzn-select" style="width:250px;" name="con_sts">
								<option value="">All Clients</option>
								<option value="Active">Active</option>
								<option value="Inactive">Inactive</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">With Logo?</div>
							<input type="radio" name="withlogo" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
							<input type="radio" name="withlogo" value="No"> No &nbsp; &nbsp;
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2">
	<form id="form2" class="stdform" method="post" action="Billing?id=search">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Due Clients Search</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Zone</div>
							<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select" style="width:250px;">
							<?php if($user_type == 'billing'){} else{ ?>
								<option value="all"<?php if('all' == (isset($_POST['z_id']) ? $_POST['z_id'] : '')) echo 'selected="selected"';?>> All Zone </option>
							<?php } while ($rowdd=mysql_fetch_array($resultedfg)) { ?>
								<option value="<?php echo $rowdd['z_id']?>"<?php if($rowdd['z_id'] == (isset($_POST['z_id']) ? $_POST['z_id'] : '')) echo 'selected="selected"';?>><?php echo $rowdd['z_name']; ?></option>
										<?php } ?>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Clients Status</div>
							<select class="select-ext-large chzn-select" style="width:250px;" name="con_sts">
								<option value="all"<?php if('all' == (isset($_POST['con_sts']) ? $_POST['con_sts'] : '')) echo 'selected="selected"';?>>All Clients</option>
								<option value="Active"<?php if('Active' == (isset($_POST['con_sts']) ? $_POST['con_sts'] : '')) echo 'selected="selected"';?>>Active</option>
								<option value="Inactive"<?php if('Inactive' == (isset($_POST['con_sts']) ? $_POST['con_sts'] : '')) echo 'selected="selected"';?>>Inactive</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Deleted Status</div>
							<select class="select-ext-large chzn-select" style="width:250px;" name="sts">
								<option value="all"<?php if('all' == (isset($_POST['sts']) ? $_POST['sts'] : '')) echo 'selected="selected"';?>> All Status </option>
								<option value="1"<?php if('1' == (isset($_POST['sts']) ? $_POST['sts'] : '')) echo 'selected="selected"';?>>Deleted</option>
								<option value="0"<?php if('0' == (isset($_POST['sts']) ? $_POST['sts'] : '')) echo 'selected="selected"';?>>Not Deleted</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Payment Method</div>
							<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select"  style="width:250px;">
								<option value="all"<?php if('all' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>> All Payment Method </option>
								<option value="Home Cash"<?php if('Home Cash' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Cash from Home</option>
								<option value="Cash"<?php if('Cash' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Cash</option>
								<option value="Office"<?php if('Office' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Office</option>
								<option value="bKash"<?php if('bKash' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>bKash</option>
								<option value="Rocket"<?php if('Rocket' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Rocket</option>
								<option value="iPay"<?php if('iPay' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>iPay</option>
								<option value="Card"<?php if('Card' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Card</option>
								<option value="Bank"<?php if('Bank' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Bank</option>
								<option value="Corporate"<?php if('Corporate' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Corporate</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Partial</div>
							<select class="select-ext-large chzn-select" style="width:250px;" name="partial">
								<option value="all"<?php if('all' == (isset($_POST['partial']) ? $_POST['partial'] : '')) echo 'selected="selected"';?>> All Due </option>
								<option value="1"<?php if('1' == (isset($_POST['partial']) ? $_POST['partial'] : '')) echo 'selected="selected"';?>>Partial Due</option>
								<option value="2"<?php if('2' == (isset($_POST['partial']) ? $_POST['partial'] : '')) echo 'selected="selected"';?>>Not Partial Due</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Deadline</div>
							<select class="chzn-select" style="width:125px;" name="df_date">
								<option value="all"<?php if('all' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> From Deadline </option>
									<option value="01"<?php if('01' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 1st</option>
									<option value="02"<?php if('02' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 2nd</option>
									<option value="03"<?php if('03' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 3rd</option>
									<option value="04"<?php if('04' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 4th</option>
									<option value="05"<?php if('05' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 5th</option>
									<option value="06"<?php if('06' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 6th</option>
									<option value="07"<?php if('07' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 7th</option>
									<option value="08"<?php if('08' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 8th</option>
									<option value="09"<?php if('09' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 9th</option>
									<option value="10"<?php if('10' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 10th</option>
									<option value="11"<?php if('11' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 11th</option>
									<option value="12"<?php if('12' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 12th</option>
									<option value="13"<?php if('13' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 13th</option>
									<option value="14"<?php if('14' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 14th</option>
									<option value="15"<?php if('15' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 15th</option>
									<option value="16"<?php if('16' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 16th</option>
									<option value="17"<?php if('17' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 17th</option>
									<option value="18"<?php if('18' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 18th</option>
									<option value="19"<?php if('19' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 19th</option>
									<option value="20"<?php if('20' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 20th</option>
									<option value="21"<?php if('21' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 21th</option>
									<option value="22"<?php if('22' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 22th</option>
									<option value="23"<?php if('23' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 23th</option>
									<option value="24"<?php if('24' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 24th</option>
									<option value="25"<?php if('25' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 25th</option>
									<option value="26"<?php if('26' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 26th</option>
									<option value="27"<?php if('27' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 27th</option>
									<option value="28"<?php if('28' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 28th</option>
									<option value="29"<?php if('29' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 29th</option>
									<option value="30"<?php if('30' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 30th</option>
									<option value="31"<?php if('31' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 31th</option>
							</select>
							<select data-placeholder="Choose a Deadline" name="dt_date" class="chzn-select"  style="width:125px;">
									<option value="all"<?php if('all' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> To Deadline </option>
									<option value="01"<?php if('01' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 1st</option>
									<option value="02"<?php if('02' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 2nd</option>
									<option value="03"<?php if('03' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 3rd</option>
									<option value="04"<?php if('04' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 4th</option>
									<option value="05"<?php if('05' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 5th</option>
									<option value="06"<?php if('06' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 6th</option>
									<option value="07"<?php if('07' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 7th</option>
									<option value="08"<?php if('08' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 8th</option>
									<option value="09"<?php if('09' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 9th</option>
									<option value="10"<?php if('10' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 10th</option>
									<option value="11"<?php if('11' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 11th</option>
									<option value="12"<?php if('12' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 12th</option>
									<option value="13"<?php if('13' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 13th</option>
									<option value="14"<?php if('14' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 14th</option>
									<option value="15"<?php if('15' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 15th</option>
									<option value="16"<?php if('16' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 16th</option>
									<option value="17"<?php if('17' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 17th</option>
									<option value="18"<?php if('18' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 18th</option>
									<option value="19"<?php if('19' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 19th</option>
									<option value="20"<?php if('20' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 20th</option>
									<option value="21"<?php if('21' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 21th</option>
									<option value="22"<?php if('22' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 22th</option>
									<option value="23"<?php if('23' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 23th</option>
									<option value="24"<?php if('24' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 24th</option>
									<option value="25"<?php if('25' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 25th</option>
									<option value="26"<?php if('26' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 26th</option>
									<option value="27"<?php if('27' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 27th</option>
									<option value="28"<?php if('28' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 28th</option>
									<option value="29"<?php if('29' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 29th</option>
									<option value="30"<?php if('30' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 30th</option>
									<option value="31"<?php if('31' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 31th</option>
							</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
		<div class="searchbar" style="margin-right: 10px;">
				<a class="btn" style="border-radius: 3px;border: 1px solid red;color: red;padding: 5px 8px;font-size: 17px;" href="#myModal2" data-toggle="modal" title='Search Due Clients'><i class="iconfa-search"></i></a>
        </div>
        <div class="pageicon"><i class="iconfa-dashboard"></i></div>
        <div class="pagetitle">
            <h1>Traffic</h1>
        </div>
    </div><!--pageheader-->
	<?php if('error' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Error!!</strong> This Payment Already Added.
		</div>
		<?php } ?>
			<div class="modal-content" style="border-bottom: 2px solid #3c8dbc;">
				<div class="modal-body" style="padding: 5px;">
				<?php if(in_array(140, $access_arry)){?>
					<table style="width: 100%;border-bottom: 0px;" class="table table-bordered responsive">
						<thead>
						  <tr>
							<td class='center' style="width: 10%;padding: 0px;font-size: 13px;font-weight: bold;">
								<select name="search_way" style="width:100%;" data-placeholder="Select Type" id="search_way" class="chzn-select">
									<option style="text-align: Left;" value="client_wise">Client Wise</option>
									<option style="text-align: Left;" value="zone_wise">Zone Wise</option>
									<option style="text-align: Left;" value="box_wise">Box Wise</option>
									<option style="text-align: Left;" value="package_wise">Package Wise</option>
								</select>
							</td>
							<td class='center' style="width: 15%;padding: 0px;font-size: 13px;font-weight: bold;">
								<select name="z_id" style="width:100%;" data-placeholder="Select a Zone" id="z_id" class="chzn-select" onChange="getRoutePoint(this.value)"/>
									<option style="text-align: Left;"value="all">All Zone</option>
									<?php while ($rowz=mysql_fetch_array($resultff)) { ?>
										<option style="text-align: Left;" value="<?php echo $rowz['z_id']?>"><?php echo $rowz['z_name'];?> <?php if($rowz['z_bn_name'] != ''){echo '('.$rowz['z_bn_name'].')';}?></option>
									<?php } ?>
								</select>
							</td>
							
							<td class='center' style="width: 10%;padding: 0px;font-size: 13px;font-weight: bold;">
							<div id="Pointdiv1">
								<select name="box_id" style="width:90%;" data-placeholder="Select Box" id="box_id" class="chzn-select"/>
									<option value="all">All Boxs</option>
								</select>
							</div>
							</td>
							
							<td class='center' style="width: 10%;padding: 0px;"><input type="text" name="f_date" value="<?php echo $t_date;?>" placeholder="Date From" style="text-align: center;width: 80%;font-size: 13px;font-weight: bold;" id="f_date" class="datepicker"></td>
							<td class='center' style="width: 10%;padding: 0px;"><input type="text" name="t_date" value="<?php echo $t_date;?>" placeholder="Date To" style="text-align: center;width: 80%;font-size: 13px;font-weight: bold;" id="t_date" class="datepicker"></td>
							
							<td class='center' style="width: 10%;padding: 0px;font-size: 13px;font-weight: bold;">
								<select name="sort_by" style="width:100%;" data-placeholder="Sort By" id="sort_by" class="chzn-select">
									<option style="text-align: Left;" value="hour" selected="selected">Hour</option>
									<option style="text-align: Left;" value="day">DAY</option>
									<!---<option style="text-align: Left;" value="month">MONTH</option>--->
								</select>
							</td>
							
							<td class='center' style="width: 10%;padding: 0px;font-size: 13px;font-weight: bold;vertical-align: middle;">
								<form id="form2" class="stdform" method="post" action="<?php $PHP_SELF;?>">
								<select name="bill_month" class="" style="height: 30px;width: 80%;text-align: center;font-weight: bold;" onchange="submit();">
									<option value="<?php echo date("Y-m-01") ?>"><?php echo date("F-Y") ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
								</select>
							</form>
							</td>
						  </tr>
						</thead>
					</table>
					<?php } ?>
				</div>
			</div>
		<!---<div id="chart_div" style="width: 100%; height: 300px;"></div>--->

		<span id="resultpackall"></span>
<?php }
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[0,'desc']],
            "sScrollY": "1000px"
        });
    });
</script>


<script type="text/javascript">
jQuery(document).ready(function(){  
    jQuery("#resultpackall").load("traffic-count.php?way=traffic_search&z_id=all&box_id=all&search_way=client_wise&sort_by=hour&f_date=<?php echo $t_date;?>&t_date=<?php echo $t_date;?>");
    jQuery('#z_id, #box_id, #search_way, #f_date, #t_date, #sort_by, #Pointdiv1').on('change',function(){ 
        var z_id = jQuery('#z_id').val();
        var box_id = jQuery('#box_id').val();
        var search_way = jQuery('#search_way').val();
        var f_date = jQuery('#f_date').val();
        var t_date = jQuery('#t_date').val();
		var sort_by = jQuery('#sort_by').val();
        jQuery.ajax({  
				type: 'GET',
                url: "traffic-count.php?way=traffic_search",
                data:{z_id:z_id,box_id:box_id,search_way:search_way,f_date:f_date,t_date:t_date,sort_by:sort_by},
                success:function(data){
                    jQuery('#resultpack').html(data);
					  if(data > 0){
							jQuery('#etheah').html('<button class="btn ownbtn4" type="submit" onclick="return checksubmit()">SUBMIT</button>');
							jQuery('#etheah1').css('display', 'block');
						}
						else{
							jQuery('#etheah').html('');
							jQuery('#etheah1').css('display', 'none');
						}
                }
        });  
        jQuery.ajax({  
				type: 'GET',
                url: "traffic-count.php?way=traffic_search",
                data:{z_id:z_id,box_id:box_id,search_way:search_way,f_date:f_date,t_date:t_date,sort_by:sort_by},
                success:function(data){
                    jQuery('#resultpackall').html(data);
                }
        });  
    });  
});
</script>
<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	
	function getRoutePoint(afdId) {		
		
		var strURL="findzonebox20.php?z_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
<style>
.google-visualization-atl .legend-dot{
			height: 10px;
			width: 10px;
}
.google-visualization-atl .legend{
	font-size: 15px;
	font-weight: bold;
}
</style>
