<?php
$titel = "Collection";
$Billing = 'active';
include("conn/connection.php");
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
if($user_type == 'mreseller'){
	if($f_date != '' && $t_date != '' && $radiofield == 'collections'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
						FROM payment_mac_client AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '1' AND p.pay_ent_date between '$f_date' AND '$t_date' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
	}
	if($f_date != '' && $t_date != '' && $radiofield == 'discounts'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
						FROM payment_mac_client AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '1' AND p.bill_discount != '0.00' AND p.pay_ent_date between '$f_date' AND '$t_date' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
	}
	if($f_date != '' && $t_date != '' && $radiofield == 'others_bank'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
						FROM payment_mac_client AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '1' AND b.emp_id = '' AND p.pay_ent_date between '$f_date' AND '$t_date' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
	}
	if($f_date == '' && $t_date == '' && $radiofield == ''){
	$f_date = date('Y-m-01', time());
	$t_date = date('Y-m-d', time());
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_name, c.c_id, c.address, c.cell, pk.p_price, p.pay_mode, pk.p_name, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
						FROM payment_mac_client AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '1' AND p.pay_ent_date between '$f_date' AND '$t_date' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
	}

	if($radiofield == 'discounts'){
	$sql19 = mysql_query("SELECT IFNULL(SUM(p.pay_amount), 0.00) AS paidamount, IFNULL(SUM(p.bill_discount), 0.00) AS discountamount FROM payment_mac_client AS p LEFT JOIN clients AS c ON c.c_id = p.c_id WHERE p.pay_ent_date between '$f_date' AND '$t_date' AND p.bill_discount != '0.00' AND c.z_id = '$macz_id'");
	$row19 = mysql_fetch_array($sql19);
	$tit = "<div class='box-header'>
				<div class='hil' style='font-weight: bold;'> Total Collection: <i style='color: green'>{$row19['paidamount']} ৳</i></div> 
				<div class='hil' style='font-weight: bold;'> Discount: <i style='color: #e3052e'>{$row19['discountamount']} ৳</i></div> 
			</div>";
	}
	else{
	$sql19 = mysql_query("SELECT IFNULL(SUM(p.pay_amount), 0.00) AS paidamount, IFNULL(SUM(p.bill_discount), 0.00) AS discountamount FROM payment_mac_client AS p LEFT JOIN clients AS c ON c.c_id = p.c_id WHERE p.pay_ent_date between '$f_date' AND '$t_date' AND c.z_id = '$macz_id'");
	$row19 = mysql_fetch_array($sql19);
	$tit = "<div class='box-header'>
				<div class='hil' style='font-weight: bold;'> Total Collection: <i style='color: green'>{$row19['paidamount']} ৳</i></div> 
				<div class='hil' style='font-weight: bold;'> Discount: <i style='color: #e3052e'>{$row19['discountamount']} ৳</i></div> 
			</div>";
	}
}
else{
if($user_type == 'billing'){
	if($f_date != '' && $t_date != '' && $radiofield == 'collections'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc, p.checked
						FROM payment AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank 
						LEFT JOIN zone AS z ON z.z_id = c.z_id 
						LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '0' AND p.pay_ent_date between '$f_date' AND '$t_date' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY p.id ASC");
	}
	if($f_date != '' && $t_date != '' && $radiofield == 'discounts'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc, p.checked
						FROM payment AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '0' AND p.bill_discount != '0.00' AND p.pay_ent_date between '$f_date' AND '$t_date' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY p.id ASC");
	}
	if($f_date != '' && $t_date != '' && $radiofield == 'others_bank'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc, p.checked
						FROM payment AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '0' AND b.emp_id = '' AND p.pay_ent_date between '$f_date' AND '$t_date' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY p.id ASC");
	}
	if($f_date == '' && $t_date == '' && $radiofield == ''){
	$f_date = date('Y-m-01', time());
	$t_date = date('Y-m-d', time());
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_name, c.c_id, c.address, c.cell, pk.p_price, p.pay_mode, pk.p_name, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc, p.checked
						FROM payment AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '0' AND p.pay_ent_date between '$f_date' AND '$t_date' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY p.id ASC");
	}

	if($radiofield == 'discounts'){
	$sql19 = mysql_query("SELECT IFNULL(SUM(p.pay_amount), 0.00) AS paidamount, IFNULL(SUM(p.bill_discount), 0.00) AS discountamount FROM payment AS p LEFT JOIN clients AS c ON c.c_id = p.c_id LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE p.pay_ent_date between '$f_date' AND '$t_date' AND p.bill_discount != '0.00' AND FIND_IN_SET('$e_id', z.emp_id) > 0");
	$row19 = mysql_fetch_array($sql19);
	$tit = "<div class='box-header'>
				<div class='hil' style='font-weight: bold;'> Total Collection: <i style='color: green'>{$row19['paidamount']} ৳</i></div> 
				<div class='hil' style='font-weight: bold;'> Discount: <i style='color: #e3052e'>{$row19['discountamount']} ৳</i></div> 
			</div>";
	}
	else{
	$sql19 = mysql_query("SELECT IFNULL(SUM(p.pay_amount), 0.00) AS paidamount, IFNULL(SUM(p.bill_discount), 0.00) AS discountamount FROM payment AS p LEFT JOIN clients AS c ON c.c_id = p.c_id LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE p.pay_ent_date between '$f_date' AND '$t_date' AND FIND_IN_SET('$e_id', z.emp_id) > 0");
	$row19 = mysql_fetch_array($sql19);
	$tit = "<div class='box-header'>
				<div class='hil' style='font-weight: bold;'> Total Collection: <i style='color: green'>{$row19['paidamount']} ৳</i></div> 
				<div class='hil' style='font-weight: bold;'> Discount: <i style='color: #e3052e'>{$row19['discountamount']} ৳</i></div> 
			</div>";
	}
}
else{
	if($f_date != '' && $t_date != '' && $radiofield == 'collections'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc, p.checked
						FROM payment AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '0' AND p.pay_ent_date between '$f_date' AND '$t_date' ORDER BY p.id ASC");
	}
	if($f_date != '' && $t_date != '' && $radiofield == 'discounts'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc, p.checked
						FROM payment AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '0' AND p.bill_discount != '0.00' AND p.pay_ent_date between '$f_date' AND '$t_date' ORDER BY p.id ASC");
	}
	if($f_date != '' && $t_date != '' && $radiofield == 'others_bank'){
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_id, c.c_name, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc, p.checked
						FROM payment AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '0' AND b.emp_id = '' AND p.pay_ent_date between '$f_date' AND '$t_date' ORDER BY p.id ASC");
	}
	if($f_date == '' && $t_date == '' && $radiofield == ''){
	$f_date = date('Y-m-01', time());
	$t_date = date('Y-m-d', time());
	$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.pay_date, '%D %M %Y') AS pay_date, DATE_FORMAT(p.pay_date_time, '%T') AS pay_date_time, p.sender_no, m.Name AS mk_name, p.trxid, b.bank_name, z.z_name, c.c_name, c.c_id, c.address, c.cell, pk.p_price, p.pay_mode, pk.p_name, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc, p.checked
						FROM payment AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id
						LEFT JOIN package AS pk ON c.p_id = pk.p_id
						LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
						LEFT JOIN bank AS b ON b.id = p.bank LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
						WHERE c.mac_user = '0' AND p.pay_ent_date between '$f_date' AND '$t_date' ORDER BY p.id ASC");
	}

	if($radiofield == 'discounts'){
	$sql19 = mysql_query("SELECT IFNULL(SUM(p.pay_amount), 0.00) AS paidamount, IFNULL(SUM(p.bill_discount), 0.00) AS discountamount FROM payment AS p WHERE p.pay_ent_date between '$f_date' AND '$t_date' AND p.bill_discount != '0.00'");
	$row19 = mysql_fetch_array($sql19);
	$tit = "<div class='box-header'>
				<div class='hil' style='font-weight: bold;'> Total Collection: <i style='color: green'>{$row19['paidamount']} ৳</i></div> 
				<div class='hil' style='font-weight: bold;'> Discount: <i style='color: #e3052e'>{$row19['discountamount']} ৳</i></div> 
			</div>";
	}
	else{
	$sql19 = mysql_query("SELECT IFNULL(SUM(p.pay_amount), 0.00) AS paidamount, IFNULL(SUM(p.bill_discount), 0.00) AS discountamount FROM payment AS p WHERE p.pay_ent_date between '$f_date' AND '$t_date'");
	$row19 = mysql_fetch_array($sql19);
	$tit = "<div class='box-header'>
				<div class='hil' style='font-weight: bold;'> Total Collection: <i style='color: green'>{$row19['paidamount']} ৳</i></div> 
				<div class='hil' style='font-weight: bold;'> Discount: <i style='color: #e3052e'>{$row19['discountamount']} ৳</i></div> 
			</div>";
	}

}
}
?>
	<div class="pageheader">
        <div class="searchbar">
		<form id="" name="form" class="stdform" style="margin-top: -8px;" method="post" action="<?php echo $PHP_SELF;?>">
			<div style="float: left;font-weight: bold;">
				<input type="text" name="f_date" id="" style="width:44%;text-align: center;" placeholder="From Date" class="surch_emp datepicker" value="<?php echo $f_date; ?>" required=""/>
				<input type="text" name="t_date" id="" style="width:44%;text-align: center;" placeholder="To Date" class="surch_emp datepicker" value="<?php echo $t_date; ?>" required=""/><br>
				<input type="radio" name="radiofield" <?php if('collections' == $radiofield or $radiofield == ''){echo "checked='checked'";}?> value="collections" />All Collections &nbsp; &nbsp;
				<input type="radio" name="radiofield" <?php if('discounts' == $radiofield){echo "checked='checked'";}?>  value="discounts"/>All Discounts &nbsp; &nbsp;
				<input type="radio" name="radiofield" <?php if('others_bank' == $radiofield){echo "checked='checked'";}?>  value="others_bank"/>Others Bank &nbsp; &nbsp;
			</div>
			<div style="float: left;">
				<button class="btn col1" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
			</div>
		</form>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Collection</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<h5><?php echo $tit;?></h5>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
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
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
						
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">MR NO</th>
							<th class="head1">Date Time</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head1">Address/Zone/CCR</th>
							<th class="head0">Package/Price</th>
							<th class="head0">Recive by/Bank</th>
							<th class="head1 center">Method</th>
							<th class="head1 center">Discount</th>
							<th class="head0 center">Amount</th>
							<th class="head1">Note</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php

								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									
									if($user_type == 'admin' || $user_type == 'superadmin'){
										if($row['checked'] == '0'){
											$aaa = "<li><form action='BillPaymentAppv' method='post' target='_blank'><input type='hidden' name='checked_by' value='{$e_id}'/><input type='hidden' name='checked' value='{$row['id']}'/><button class='btn ownbtn4' style='padding: 6px 9px;'><i class='iconfa-thumbs-up'></i></button></form></li>";
										}
										else{
											$aaa = "<li><button class='btn ownbtn3' style='padding: 6px 9px;'><i class='iconfa-ok'></i></button></li>";
										}
									}
									else{
										$aaa = "";
									}
									if($row['address'] == ''){
										$addressnull = 'NULL';
									}
									else{
										$addressnull = $row['address'];
									}
									echo
										"<tr class='gradeX'>
											<td class='center'>{$row['id']}</td>
											<td><b>{$row['pay_date']}</b><br>{$row['pay_date_time']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}</td>
											<td>{$addressnull}<br>{$row['z_name']}<br><b>[{$row['mk_name']}]</b></td>
											<td>{$row['p_name']}<br>({$row['p_price']} tk)</td>
											<td>{$row['e_name']}<br>{$row['bank_name']}</td>
											<td class='center'><b>{$row['pay_mode']}</b><br>{$row['sender_no']}<br>{$row['trxid']}</td>
											<td class='center'>{$row['bill_discount']}</td>
											<td class='center' style='font-size: 14px;color: #044a8e;'><b>{$row['pay_amount']}</b></td>
											<td>{$row['pay_desc']}</td>
											<td class='center' style='padding: 17px 10px;'>
												<ul class='tooltipsample'>
													{$aaa}
													<li><form action='BillPaymentView' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='View Bill & Payment'><input type='hidden' name='id' value='{$row['c_id']}' /><button class='btn ownbtn12' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>			
	</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script>
<style>
#dyntable_length{display: none;}
</style>