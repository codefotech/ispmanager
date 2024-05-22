<?php
$titel = "Reseller Date Wise Recharge History";
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


$sql1 = mysql_query("SELECT b.id AS bill_id, b.c_id, z.z_name, p.p_name, b.start_date, b.start_time, b.end_date, b.days, b.p_price, b.bill_amount, e.e_name AS entryby, b.entry_by AS auto_entry, b.entry_date, b.entry_time FROM billing_mac AS b
					LEFT JOIN package AS p ON p.p_id = b.p_id
					LEFT JOIN zone AS z ON z.z_id = b.z_id
					LEFT JOIN emp_info AS e ON e.e_id = b.entry_by
                    WHERE b.z_id = '$z_id' AND  b.entry_date = '$add_date' ORDER BY b.id asc");

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
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Reseller Date Wise Recharge History</h1>
        </div>
    </div><!--pageheader-->		
	<div class="box box-primary">
		<div class="box-header">
			<h5>Recharge Date: <?php echo $add_date;?></h5>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">S/L</th>
							<th class="head1 center">Client ID</th>
							<th class="head0 center">Date</th>
							<th class="head1">Package</th>
							<th class="head1 center">Start Date</th>
							<th class="head0 center">End Date</th>
							<th class="head1 center">Days</th>
							<th class="head0 center">Recharge Amount</th>
							<th class="head1 center">Entry By</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		$x=1;
								while( $row = mysql_fetch_assoc($sql1) )
								{
										echo
										"<tr class='gradeX'>
											<td class='center'>{$x}</td>
											<td class='center'>{$row['c_id']}</td>
											<td><b style='font-size: 14px;color: purple;' class='center'>{$row['entry_date']}</b><br>{$row['entry_time']}</td>
											<td>{$row['p_name']}<br>{$row['p_price']}</td>
											<td style='font-size: 14px;font-weight: bold;color: green;' class='center'>{$row['start_date']}</td>
											<td style='font-size: 14px;font-weight: bold;color: red;' class='center'>{$row['end_date']}</td>
											<td style='font-size: 20px;font-weight: bold;color: #0b0a0b;' class='center'>{$row['days']}</td>
											<td style='font-size: 20px;font-weight: bold;color: #0b0a0b;' class='center'>{$row['bill_amount']}</td>
											<td class='center'>{$row['entryby']}</td>
											
											<td class='center' style='width: 20px !important;'>
												<ul class='tooltipsample'>
												</ul>
											</td>
										</tr>\n ";
									$x++;
								}
								
							?>
					</tbody>
				</table>
				<br>
				<form action='MacResellerClientBillHistory' method='post'><input type='hidden' name='c_id' value="<?php echo $c_id;?>"/><?php if('archive' != (isset($_POST['way']) ? $_POST['way'] : '')) {?><input type='hidden' name='way' value="archive"/><?php } else{ ?> <input type='hidden' name='' value=""/><button type="submit" class="btn" style="float: right;font-weight: bold;font-size: 15px;color: #0866c6;">Go Back</button><?php } ?></form>
			
		</div>
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
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<style>
#dyntable_length{display: none;}

</style>