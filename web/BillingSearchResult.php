<?php
include("conn/connection.php") ;
session_start(); // NEVER FORGET TO START THE SESSION!!!
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
  if($_POST) 
  {
      $comid     = strip_tags(isset($_POST['com_id']) ? $_POST['com_id'] : '');
      $cid     = strip_tags(isset($_POST['c_id']) ? $_POST['c_id'] : '');
      $cname     = strip_tags(isset($_POST['c_name']) ? $_POST['c_name'] : '');
	  $cell     = strip_tags(isset($_POST['cell']) ? $_POST['cell'] : '');
	  $address     = strip_tags(isset($_POST['address']) ? $_POST['address'] : '');
	  $onu_mac     = strip_tags(isset($_POST['onu_mac']) ? $_POST['onu_mac'] : '');
	  $ip     = strip_tags(isset($_POST['ip']) ? $_POST['ip'] : '');
	  $z_id     = strip_tags(isset($_POST['z_id']) ? $_POST['z_id'] : '');
	  $payment_deadline     = strip_tags(isset($_POST['payment_deadline']) ? $_POST['payment_deadline'] : '');
	  $b_date     = strip_tags(isset($_POST['b_date']) ? $_POST['b_date'] : '');
	  

     if($comid != ''){
		$searchby = 'Searching By Company ID: '.$comid;
						$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.com_id = '$comid'";
				
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	 }
	 if($cid != ''){
		$ccid = '%'.$cid.'%';
		$searchby = 'Searching By Client ID: '.$cid;
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.c_id LIKE '$ccid'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	 }
	 
	 if($cname != ''){
		$ccname = '%'.$cname.'%';
		$searchby = 'Searching By Client Name: '.$cname;
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.c_name LIKE '$ccname'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	 }
	 	 if($cell != ''){
		 $phone = '%'.$cell.'%';
		 $searchby = 'Searching By Cell No: '.$cell;
		 $sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.cell LIKE '$phone'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	 }
	 
	if($address != ''){
		$aaa = '%'.$address.'%';
		$searchby = 'Searching By Address: '.$address;
		 $sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.address != '' AND c.address LIKE '$aaa'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	 }
	 
	if($onu_mac != ''){
		$aaae = $onu_mac.'%';
		$searchby = 'Searching By ONU MAC: '.$onu_mac;
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.onu_mac != '' AND c.onu_mac LIKE '$aaae'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	 }
	if($ip != ''){
		$aaae = $ip.'%';
		$searchby = 'Searching By IP Address: '.$ip;
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.ip != '' AND c.ip LIKE '$aaae'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
		}
	 
	if($payment_deadline != '' && $payment_deadline != 'no'){
		if($payment_deadline < '10'){
			$dfhhfh = strlen($payment_deadline);
			if($dfhhfh < '2'){
				$fhhjdj = '0'.$payment_deadline;
			}
			else{
			$fhhjdj = $payment_deadline;
		}
		}
		else{
			$fhhjdj = $payment_deadline;
		}
		
		$searchby = 'Searching By P.Deadline: '.$fhhjdj;
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.payment_deadline = '$fhhjdj'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	}
	if($payment_deadline != '' && $payment_deadline == 'no'){
		$searchby = 'Searching Who Have Not Payment Deadline.';
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.payment_deadline = ''";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
		}

	if($b_date != '' && $b_date != 'no'){
		if($b_date < '10'){
			$dfhhfh = strlen($b_date);
			if($dfhhfh < '2'){
				$fhhjdjf = '0'.$b_date;
			}
			else{
			$fhhjdjf = $b_date;
		}
		}
		else{
			$fhhjdjf = $b_date;
		}
		$searchby = 'Searching By B.Deadline: '.$fhhjdjd;
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.b_date = '$fhhjdjf'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	}
	if($b_date != '' && $b_date == 'no'){
		$searchby = 'Searching Who Have Not Billing Deadline.';
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.b_date = ''";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	}
	
	if($z_id != ''){
		$resultff=mysql_query("SELECT * FROM zone WHERE z_id = '$z_id'");
		$row2ff = mysql_fetch_assoc($resultff);
		$z_name = $row2ff['z_name'];
		$searchby = 'Searching By Zone: '.$z_name;
		$sql2 = "SELECT l.c_id, l.c_name, l.com_id, l.z_name, l.mk_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.b_date, l.payment_deadline, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.c_id, x.emp_id, x.z_name, x.mk_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.cell, x.p_name, x.con_sts, x.b_date, x.payment_deadline, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, x.extra_bill FROM
													(SELECT b.c_id, c.c_name, m.Name AS mk_name, c.com_id, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.cell, p.p_name, c.con_sts, c.b_date, c.payment_deadline, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount, c.extra_bill
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.mac_user != '1' AND c.z_id = '$z_id'";
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= " GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id ASC";
		$sql = mysql_query($sql2);
	 }

$tot_allbills = mysql_num_rows($sql);
	  if($tot_allbills <= 0)
	  {
		  echo "<br><br><center><span style='color:red;font-weight: bold;font-size: 30px;'>No Data Found.</span></center>";
	  }
	  else{

?>
	<div class="box box-primary" style="padding: 0px;">
		<div class="box-header">
			<h5 style="font-size: 17px;font-weight: bold;margin: 5px 0 -10px 10px;">Total Found:  <i style="color: #317EAC"><?php echo $tot_allbills;?></i>&nbsp; &nbsp;<a style="color:#444;">[ <?php echo $searchby;?> ]</a></h5>
		</div>
		<div class="box-body">
			<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />												
						<col class="con0" />
						<col class="con1" />	
                    </colgroup>
                   <thead>
                        <tr  class="newThead">
							<th class="head0">ComID</th>
							<th class="head1">ID/Name/Cell</th>
                            <th class="head0">Address/Zone/CCR</th>
							<th class="head1 center">Status</th>
							<th class="head0 center">Deadline</th>
							<th class="head1 center">Discount/Ex.Bill</th>
							<th class="head0">Package</th>
							<th class="head0 center">Payable</th>
							<th class="head1">Auto_Note</th>
							<th class="head0">Note</th>
                            <th class="head1 center" style="width: 160px !important;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
								while( $row = mysql_fetch_assoc($sql) )
								{
									$payable = number_format($row['payable'], 2);
									
									if($payable > 0){
										$color = 'style="color:red; font-weight: bold;font-size: 16px;"';					
									} 
									if($payable < 0){
										$color = 'style="color:blue; font-weight: bold;font-size: 16px;"';					
									}
									if($payable == 0){
										$color = 'style=""';					
									}
									
									if ($row['con_sts']=='Inactive')
									{
										$colo = 'style="color:red; width: 80px;font-size: 16px;"';	
									}
									else
									{
										$colo = 'style="color:green; width: 80px;font-size: 16px;"';
									}
									
									if($row['breseller'] == '1'){
										$hhhh = 'D: '.$row['raw_download'] .' + U: '.$row['raw_upload'].' + Y: '.$row['youtube_bandwidth'].' = '.$row['total_bandwidth'].'mb <br> Rate: '.$row['total_price'];
									}
									else{
										$hhhh = $row['p_name'].'<br> ('.$row['p_price'].'tk)';
									}
									echo
										"<tr class='gradeX'>
											<td class='center' style='font-weight: bold;font-size: 15px;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}</td>
											<td>{$row['address']}<br>{$row['z_name']}<br><b>[{$row['mk_name']}]</b></td>
											<td class='center' $colo><b>{$row['con_sts']}</b></td>
											<td><b>PD: {$row['payment_deadline']}<br>BD: {$row['b_date']}</b></td>
											<td class='center'><b>Pr.D: {$row['discount']}<br>Ex.B: {$row['extra_bill']}</b></td>
											<td>{$hhhh}</td>
											
												
											<td $color class='center'>{$payable}</td>
											<td>{$row['note_auto']}</td>
											<td>{$row['note']}</td>
											<td class='center' style='width: 230px !important;font-size: 11px;'>
												<ul class='tooltipsample'>
													<li><form action='PaymentAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='{$row['c_id']}' /><button class='btn ownbtn2' style='padding: 6px 9px;' target='_blank'><i class='iconfa-money'></i></button></form></li>
													<li><form action='PaymentOnlineAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='{$row['c_id']}' /><button class='btn ownbtn3' style='padding: 6px 9px;' target='_blank'><i class='iconfa-shopping-cart'></i></button></form></li>
													<li><a data-placement='top' data-rel='tooltip' href='BillPaymentView?id={$row['c_id']}' data-original-title='View' class='btn ownbtn2' style='padding: 6px 9px;' target='_blank'><i class='iconfa-eye-open'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='BillPrintInvoice?id={$row['c_id']}' data-original-title='Print Invoice' class='btn ownbtn5' style='padding: 6px 9px;' target='_blank'><i class='iconfa-print'></i></a></li>
													<li><form action='fpdf/BillPrintInvoice' method='post' target='_blank'><input type='hidden' name='c_id' value='{$row['c_id']}' /><input type='hidden' name='e_id' value='<?php echo $e_id;?>' /><button class='btn ownbtn4' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>
												</ul>
											</td>
										</tr>\n";
								}
								?>
</tbody>
</table>
</div>
</div>
	  <?php  }
	  
	  } ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<style>
#dyntable_length{display: none;}
</style>
