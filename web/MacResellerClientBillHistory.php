<?php
$titel = "Mac Client Recharge History";
$MacReseller = 'active';
include('include/hader.php');
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'MacReseller' OR 'MacResellerBillHistory' AND $user_type = '1'");
if($user_type == 'mreseller'){
	$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '40' AND $user_type = '1' or $user_type = '2'");
}
else{
	$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '39' AND $user_type = '1' or $user_type = '2'");
}
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

$c_id = (isset($_POST['c_id']) ? $_POST['c_id'] : '');

if('archive' == (isset($_POST['way']) ? $_POST['way'] : '')){
$sql1 = mysql_query("SELECT b.id AS bill_id, b.c_id, z.z_name, p.p_name, b.start_date, b.start_time, b.end_date, b.days, b.p_price, b.bill_amount, e.e_name AS entryby, b.entry_by AS auto_entry, b.entry_date, b.entry_time FROM billing_mac_archive AS b
					LEFT JOIN package AS p ON p.p_id = b.p_id
					LEFT JOIN zone AS z ON z.z_id = b.z_id
					LEFT JOIN emp_info AS e ON e.e_id = b.entry_by

					WHERE b.c_id = '$c_id' ORDER BY b.id DESC");
}
else{
$sql1 = mysql_query("SELECT b.id AS bill_id, b.c_id, z.z_name, p.p_name, b.start_date, b.start_time, b.end_date, b.days, b.p_price, b.bill_amount, e.e_name AS entryby, b.entry_by AS auto_entry, b.entry_date, b.entry_time FROM billing_mac AS b
					LEFT JOIN package AS p ON p.p_id = b.p_id
					LEFT JOIN zone AS z ON z.z_id = b.z_id
					LEFT JOIN emp_info AS e ON e.e_id = b.entry_by

					WHERE b.c_id = '$c_id' ORDER BY b.id DESC");
}
$result = mysql_query("SELECT c_id, c_name, cell, address, termination_date, archived_date_time FROM clients WHERE c_id = '$c_id'");
$row = mysql_fetch_array($result);	
	?>
<link rel="stylesheet" href="css/reset-fonts-grids.css" type="text/css" />
<link rel="stylesheet" href="css/resume.css" type="text/css" />
	<script language="javascript">
		function PrintMe(DivID) {
		var disp_setting="toolbar=yes,location=no,";
		disp_setting+="directories=yes,menubar=yes,";
		disp_setting+="scrollbars=yes,width=1050, height=800, left=50, top=25";
		   var content_vlue = document.getElementById(DivID).innerHTML;
		   var docprint=window.open("","",disp_setting);
		   docprint.document.open();
		   docprint.document.write('<link rel="stylesheet" href="css/resume_print.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/reset-fonts-grids_print.css" type="text/css" />');
		   docprint.document.write('<head><title>MacReseller Client Recharge History</title>');
		   docprint.document.write('<style type="text/css">body{ margin:0px;');
		   docprint.document.write('font-family:verdana,Arial;color:#000;');
		   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
		   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
		   docprint.document.write('</head><body onLoad="self.print()"><center>');
		   docprint.document.write(content_vlue);
		   docprint.document.write('</center></body></html>');
		   docprint.document.close();
		   docprint.focus();
		}
	</script>
	
	<div class="pageheader">
        <div class="searchbar">
			<form action='MacResellerClientBillHistory' method='post'><input type='hidden' name='c_id' value="<?php echo $c_id;?>"/><?php if('archive' != (isset($_POST['way']) ? $_POST['way'] : '')) {?><input type='hidden' name='way' value="archive"/><?php } else{ ?> <input type='hidden' name='' value=""/><button type="submit" class="btn" style="float: right;font-weight: bold;font-size: 15px;color: #0866c6;">Go Back</button><?php } ?></form>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
           <?php if('archive' == (isset($_POST['way']) ? $_POST['way'] : '')){ ?> <h1>Archived Recharge History</h1> <?php } else{ ?><h1>Recharge History</h1><?php } ?>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
		<?php if('delete' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong style="font-weight: normal !important;">Success!!</strong> Recharge History Successfully Deleted from Database.
			</div><!--alert-->
		<?php } if('sorry' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong style="font-weight: normal !important;">Sorry!!</strong> Not Possible to Delete. Dont try again.
			</div><!--alert-->
		<?php } ?>
		<div id="divid">
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:right">Clint ID&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['c_id']; ?></td>
								
						<th style="text-align:right">Clint Name&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['c_name']; ?></td>
							
						<th style="text-align:right">Cell No&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['cell']; ?></td>
							
						<th style="text-align:right">Termination Date Due&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['termination_date']; ?></td>
					</tr>	
				</table>
			</div>
			<div id="hd">
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">S/L</th>
							<th class="head0 center">Date</th>
							<th class="head1">Package</th>
							<th class="head0">Price</th>
							<th class="head1 center">Start Date</th>
							<th class="head0 center">End Date</th>
							<th class="head1 center">Days</th>
							<th class="head0 center">Recharge Amount</th>
							<th class="head1 center">Entry By</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $row = mysql_fetch_assoc($sql1) )
								{
									if($row['auto_entry'] == 'Auto_Recharged' && 'archive' == (isset($_POST['way']) ? $_POST['way'] : '')){
										$sgssgfg = 'Auto Recharged';
										$ss = "<li><form action='MacResellerClientBillHistoryDelete' method='post'><input type='hidden' name='bill_id' value='{$row['bill_id']}' /><input type='hidden' name='usertype' value='{$user_type}' /><a data-placement='top' data-rel='tooltip' data-original-title='Delete'><button class='btn col5' onclick='return checkDelete()'><i class='iconfa-remove'></i></button></a></form></li>";
									}
									elseif($row['auto_entry'] == 'Archived'){
										$sgssgfg = "<form action='MacResellerClientBillHistory' method='post'><input type='hidden' name='c_id' value='{$c_id}'/><input type='hidden' name='way' value='archive'/><button type='submit' class='btn' style='font-weight: bold;font-size: 15px;color: #0866c6;'>Archived</button></form>";
										$ss = "";
									}
									else{
										$sgssgfg = $row['entryby'];
										if('archive' != (isset($_POST['way']) ? $_POST['way'] : '')){
											$ss = "<li><form action='MacResellerClientBillHistoryDelete' method='post'><input type='hidden' name='bill_id' value='{$row['bill_id']}' /><input type='hidden' name='usertype' value='{$user_type}' /><a data-placement='top' data-rel='tooltip' data-original-title='Delete'><button class='btn col5' onclick='return checkDelete()'><i class='iconfa-remove'></i></button></a></form></li>";
										}
										else{
											$ss = "";
										}
									}
								if($user_type == 'admin' || $user_type == 'superadmin'){
									echo
										"<tr class='gradeX'>
											<td class='center'>{$row['bill_id']}</td>
											<td><b style='font-size: 14px;color: purple;' class='center'>{$row['entry_date']}</b><br>{$row['entry_time']}</td>
											<td>{$row['p_name']}</td>
											<td>{$row['p_price']}</td>
											<td style='font-size: 14px;font-weight: bold;color: green;' class='center'>{$row['start_date']}</td>
											<td style='font-size: 14px;font-weight: bold;color: red;' class='center'>{$row['end_date']}</td>
											<td style='font-size: 20px;font-weight: bold;color: #0b0a0b;' class='center'>{$row['days']}</td>
											<td style='font-size: 20px;font-weight: bold;color: #0b0a0b;' class='center'>{$row['bill_amount']}</td>
											<td class='center'>{$sgssgfg}</td>
											<td class='center' style='width: 20px !important;'>
												<ul class='tooltipsample'>
												{$ss}
												</ul>
											</td>
										</tr>\n ";
								}
								else{
										echo
										"<tr class='gradeX'>
											<td class='center'>{$row['bill_id']}</td>
											<td><b style='font-size: 14px;color: purple;' class='center'>{$row['entry_date']}</b><br>{$row['entry_time']}</td>
											<td>{$row['p_name']}</td>
											<td>{$row['p_price']}</td>
											<td style='font-size: 14px;font-weight: bold;color: green;' class='center'>{$row['start_date']}</td>
											<td style='font-size: 14px;font-weight: bold;color: red;' class='center'>{$row['end_date']}</td>
											<td style='font-size: 20px;font-weight: bold;color: #0b0a0b;' class='center'>{$row['days']}</td>
											<td style='font-size: 20px;font-weight: bold;color: #0b0a0b;' class='center'>{$row['bill_amount']}</td>
											<td class='center'>{$sgssgfg}</td>
											<td class='center' style='width: 20px !important;'>
												<ul class='tooltipsample'>
												</ul>
											</td>
										</tr>\n ";
									
								}
								}
							?>
					</tbody>
				</table>
				<br>
				<form action='MacResellerClientBillHistory' method='post'><input type='hidden' name='c_id' value="<?php echo $c_id;?>"/><?php if('archive' != (isset($_POST['way']) ? $_POST['way'] : '')) {?><input type='hidden' name='way' value="archive"/><?php } else{ ?> <input type='hidden' name='' value=""/><button type="submit" class="btn" style="float: right;font-weight: bold;font-size: 15px;color: #0866c6;">Go Back</button><?php } ?></form>
			</div>
		</div></div>
		<div class="modal-footer">
			<button class="btn btn-danger" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
		</div>
	</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete Payment!!  Are you sure?');
}
</script>
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
<style>
#dyntable_length{display: none;}
.dataTables_filter{display: none;}
</style>