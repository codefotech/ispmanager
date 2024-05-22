<?php
$titel = "Vendor Bill";
$VendorBill = 'active';
include('include/hader.php');
$VendorsID = $_GET['VendorsInfo'];
extract($_POST);

ini_alter('date.timezone','Asia/Almaty');
$this_month_yr = date('Y-m', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'VendorBill' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '49' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typee" value="vendor" />
	<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
	<input type="hidden" name="enty_time" value="<?php echo date("Y-m-d h:i:s");?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Vendor Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Vendor Name*:</div>
						<div class="col-2"><input type="text" name="v_name" id="" placeholder="Ex: Full Name" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Cell No*:</div>
						<div class="col-2"><input type="text" name="cell" id="" placeholder="Ex: 01712345678" class="input-large" required=""/></div>
					</div>					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Location*:</div>
						<div class="col-2"><input type="text" name="location" id="" placeholder="Ex: Vendor Address" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Email:</div>
						<div class="col-2"><input type="text" name="email" id="" placeholder="Ex: Email Address" class="input-large"/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Join Date:</div>
						<div class="col-2"><input type="text" name="join_date" id="" placeholder="" class="input-large datepicker" value="<?php echo date("Y-m-d");?>"/></div>
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
        <div class="searchbar">
		<?php if(in_array(175, $access_arry)){?>
			<a class="btn ownbtn7" href="ReportVendorLedger">Ledger</a>
		<?php } if(in_array(208, $access_arry)){?>
			<a class="btn ownbtn9" href="#myModal" data-toggle="modal">New Vendor</a>
		<?php } if(in_array(210, $access_arry)){?>
		<?php if($VendorsID != 'all'){ ?>	
			<a class="btn ownbtn3" href="VendorBill?VendorsInfo=all">All Vendors</a>
		<?php } else{ ?>	
			<a class="btn ownbtn3" href="VendorBill">Vendors Bills</a>
		<?php }} if(in_array(206, $access_arry)){ ?>
			<a class="btn ownbtn2" href="VendorBillAdd">Add Bill</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i> </div>
        <div class="pagetitle">
			<?php if($VendorsID != 'all'){ ?>
				<h1> Vendor Bills</h1>
			<?php } else{ ?>	
				<h1> Vendor Information</h1>
			<?php } ?>	
        </div>
    </div><!--pageheader-->	
	<?php if($sts == 'delete') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted from Your System.
		</div>
	<!--alert-->
	<?php } if($sts == 'editinfo') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> Vendor Information Successfully Edited in Your System.
	</div>
	<!--alert-->
	<?php } if($sts == 'add') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.
	</div>
	<!--alert-->
	<?php } if($sts == 'edit') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.
	</div>
	<!--alert-->
	<?php } if($VendorsID != 'all'){ if(in_array(205, $access_arry)){?>	
		<div class="box box-primary">
			<div class="box-header">
				Vendor Bills List
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">ID</th>
							<th class="head0">Date/Time</th>
                            <th class="head1">Vendor Name/Cell/Address</th>
							<th class="head0">Purpose</th>
							<th class="head1">Bill Type</th>
							<th class="head0 center">Amount</th>
							<th class="head1 center">Generate?</th>
							<th class="head0">Entry By</th>
							<th class="head1">Note</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						$sql = mysql_query("SELECT p.id AS vp_id, p.auto_generate, DATE_FORMAT(p.bill_date, '%Y-%m') AS bill_date, DATE_FORMAT(p.bill_date, '%D %M %Y') AS billdate, DATE_FORMAT(p.bill_time, '%h:%i%p') AS bill_time, p.v_id, v.v_name, p.bill_type, t.ex_type, p.purpose, v.cell, v.location, p.note, p.amount, p.ent_by, e.e_name, p.sts FROM `vendor_bill` AS p
											LEFT JOIN vendor AS v ON v.id = p.v_id
											LEFT JOIN emp_info AS e ON e.e_id = p.ent_by
											LEFT JOIN expanse_type AS t ON t.id = p.purpose
											
											WHERE p.sts = '0'");
								$x = 1;
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['auto_generate'] == '0'){
											$exxxx = "<span class='label label-important' style='font-weight: bold;margin-top: 10px;'>No<span>";
											$collrrr = 'style="color: #b94a48;font-weight: bold;"';
										}
										else{
											$exxxx = "<span class='label label-success' style='font-weight: bold;margin-top: 10px;'>Yes<span>";
											$collrrr = 'style="color: #00a65a;font-weight: bold;"';
										}
									if(in_array(207, $access_arry)){
										if($this_month_yr == $row['bill_date']){
											$aaaa = "<form action='VendorPaymentDelete' method='post'><input type='hidden' name='vp_id' value='{$row['vp_id']}' /><input type='hidden' name='e_id' value='{$e_id}' /><button class='btn ownbtn4' style='padding: 6px 9px;' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form>";
										}
									}
									
									echo
										"<tr class='gradeX'>
											<td>{$row['vp_id']}</td>
											<td><b>{$row['billdate']}</b><br>{$row['bill_time']}</td>
											<td><b>{$row['v_name']}</b><br>{$row['cell']}<br>{$row['location']}</td>
											<td>{$row['ex_type']}</td>
											<td>{$row['bill_type']}</td>
											<td class='center' style='font-size: 15px;color: #317ebe;'><b>{$row['amount']} ৳</b></td>
											<td class='center' $collrrr>{$exxxx}</td>
											<td>{$row['e_name']}</td>
											<td>{$row['note']}</td>
											<td class='center'>
												<ul class='tooltipsample' style='padding: 10px 0;'>
													<li>{$aaaa}</li>
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
	<?php }} else{ if(in_array(210, $access_arry)){?>
		<div class="box box-primary">
			<div class="box-header">
				Vendor List
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
                            <th class="head0">ID</th>
                            <th class="head1">Vendor Name</th>
							<th class="head0">Cell</th>
							<th class="head1">Address</th>
							<th class="head0">Email</th>
							<th class="head1">Joinging</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						$sql = mysql_query("SELECT `id`, `v_name`, `cell`, `email`, `location`, DATE_FORMAT(join_date, '%D %M, %Y') AS join_date FROM `vendor` WHERE `sts` = '0' ORDER BY id DESC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									if(in_array(209, $access_arry)){
										$bbbb = "<form action='VendorEdit' method='post'><input type='hidden' name='vp_id' value='{$row['id']}' /><input type='hidden' name='e_id' value='{$e_id}' /><button class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-edit'></i></button></form>";
									}
									
									echo
										"<tr class='gradeX'>
											<td>{$row['id']}</td>
											<td><b>{$row['v_name']}</b></td>
											<td>{$row['cell']}</td>
											<td>{$row['location']}</td>
											<td>{$row['email']}</td>
											<td>{$row['join_date']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li>{$bbbb}</li>
												</ul>
											</td>
										</tr>\n ";
								}
							?>
					</tbody>
				</table>
			</div>			
		</div>
<?php }	else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php }}} else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php }
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 20,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}

</style>