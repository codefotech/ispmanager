<?php
$titel = "Instruments Store Out";
$Store = 'active';
include('include/hader.php');
$pid = $_GET['pid'];
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(190, $access_arry)){
//---------- Permission -----------

$result1y = mysql_query("SELECT SUM(qty) AS totaqty FROM store_out_instruments WHERE p_id = '$pid'");
$row2226 = mysql_fetch_assoc($result1y);

if($pid != ''){
$result1ysdfsdf = mysql_query("SELECT COUNT(o.id) AS offuseing FROM store_out_instruments AS o
	LEFT JOIN clients AS c
	ON c.c_id = o.c_id
	WHERE o.status = '0' AND c.con_sts = 'Inactive' AND o.p_id = '$pid'");
}
else{
$result1ysdfsdf = mysql_query("SELECT COUNT(o.id) AS offuseing FROM store_out_instruments AS o
	LEFT JOIN clients AS c
	ON c.c_id = o.c_id
	WHERE o.status = '0' AND c.con_sts = 'Inactive'");
}
$row2r26 = mysql_fetch_assoc($result1ysdfsdf);
$offuseing = $row2r26['offuseing'];
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<a class="btn ownbtn2" href="Instruments">Instruments Details</a>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h3>Instruments Out Details</h3>
        </div>
    </div><!--pageheader-->
		<?php if($sts == 'delete') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted from Your System.
			</div><!--alert-->
		<?php } if($sts == 'add') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added from Your System.
			</div><!--alert-->
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header" style="margin-bottom: -7px;">
				<h4><b><?php if($pid == ''){?> Instruments Out Details <?php } else{ echo 'Total Out Quantity: '.$row2226['totaqty'].' pieces.'; }?></b> <b style="color: red;">[<?php echo $offuseing;?> Clients are Inactive But Useing Your Product]</b></h4>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">S/L</th>
							<th class="head0 center">Out Date & by</th>
							<th class="head0">Product</th>
							<th class="head0">S/L No/Note</th>
							<th class="head1 center">qty</th>
							<th class="head1">Client ID/Name/Cell</th>
							<th class="head0">Used by</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if($pid == ''){
							$sql = mysql_query("SELECT o.id, o.p_id, p.pro_name, o.p_sl_no, c.c_name, c.c_id, c.cell, o.qty, c.con_sts, o.out_date, e.e_name AS out_by, k.e_name AS receiveby, receive_by, o.note, DATE_FORMAT(o.out_date_time, '%D %M, %Y %r') AS out_date_time FROM store_out_instruments AS o
													LEFT JOIN product AS p
													ON p.id = o.p_id
													LEFT JOIN emp_info AS e
													ON e.e_id = o.out_by
													LEFT JOIN emp_info AS k
													ON k.e_id = o.receive_by 
													LEFT JOIN clients AS c
													ON c.c_id = o.c_id
													WHERE o.status = '0'
													ORDER BY o.out_date_time DESC");
						}
						else{
							$sql = mysql_query("SELECT o.id, o.p_id, p.pro_name, o.p_sl_no, c.c_name, c.c_id, c.cell, c.con_sts, o.qty, o.out_date, e.e_name AS out_by, k.e_name AS receiveby, receive_by, o.note, DATE_FORMAT(o.out_date_time, '%D %M, %Y %r') AS out_date_time FROM store_out_instruments AS o
													LEFT JOIN product AS p
													ON p.id = o.p_id
													LEFT JOIN emp_info AS e
													ON e.e_id = o.out_by
													LEFT JOIN emp_info AS k
													ON k.e_id = o.receive_by 
													LEFT JOIN clients AS c
													ON c.c_id = o.c_id
													WHERE o.status = '0' AND o.p_id = '$pid'
													ORDER BY o.out_date_time DESC");
						}
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['note'] != ''){
										$noteeeeeeee = '<b>NOTE: </b>'.$row['note'];
									}
									else{
										$noteeeeeeee = '';
									}
									if($row['con_sts'] == 'Inactive'){
										$inactivecolor = "style='color: red;'";
										$resultwwdd=mysql_query("SELECT DATE_FORMAT(`update_date`, '%D-%b, %y') AS offdate, TIME_FORMAT(`update_time`, '%T') AS offtime FROM `con_sts_log` WHERE `c_id` = '{$row['c_id']}' AND con_sts = 'Inactive' ORDER BY `update_date_time` DESC LIMIT 1");
										$rowmkdd = mysql_fetch_assoc($resultwwdd);
										$offdatetime = '[Since '.$rowmkdd['offdate'].' '.$rowmkdd['offtime'].']';
										$aaa = 1;
									}
									else{
										$inactivecolor = "";
										$offdatetime = "";
										$aaa = 0;
									}
									$totalloff += $aaa;
								if(in_array(194, $access_arry)){
									echo
										"<tr class='gradeX'>
											<td class='center' style='font-weight: bold;padding: 20px 5px;'>{$row['id']}</td>
											<td class='center'><b>{$row['out_date_time']}</b><br>by<br>[{$row['out_by']}]</td>
											<td style='vertical-align: middle;text-align: center;color: brown;font-size: 15px;font-weight: bold;'>{$row['pro_name']}</td>
											<td style='max-width: 250px;'>{$row['p_sl_no']}<br><br>{$noteeeeeeee}</td>
											<td class='center' style='padding: 20px 0px;font-size: 20px;color: teal;'><b>{$row['qty']}</b></td>
											<td {$inactivecolor}><b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}<br>{$offdatetime}</td>
											<td>{$row['receiveby']}<br>[{$row['receive_by']}]</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><form action='StoreOutDelete' method='post'><input type='hidden' name='id' value='{$row['id']}' /><input type='hidden' name='e_id' value='{$e_id}' /><input type='hidden' name='store_type' value='instruments' /><button class='btn ownbtn4' style='padding: 6px 9px;' title='Delete' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form></li>
												</ul>
											</td>
										</tr>\n";
								 }
								 else{
									 echo
										"<tr class='gradeX'>
											<td class='center' style='font-weight: bold;padding: 20px 5px;'>{$row['id']}</td>
											<td class='center'><b>{$row['out_date_time']}</b><br>by<br>[{$row['out_by']}]</td>
											<td style='vertical-align: middle;text-align: center;color: brown;font-size: 15px;font-weight: bold;'>{$row['pro_name']}</td>
											<td>{$row['p_sl_no']}<br><br>{$noteeeeeeee}</td>
											<td class='center' style='padding: 20px 0px;font-size: 20px;color: teal;'><b>{$row['qty']}</b></td>
											<td {$inactivecolor}><b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}<br>{$offdatetime}</td>
											<td>{$row['receiveby']}<br>[{$row['receive_by']}]</td>
											<td class='center'>
												<ul class='tooltipsample'>
												</ul>
											</td>
										</tr>\n";
								 }
								}
							?>
					</tbody>
				</table>
			</div>			
		</div>
<?php } else{ ?>
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
			"iDisplayLength": 50,
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
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Fiber out Delete!!  Are you sure?');
}

function checksts(){
    return confirm('Change connection status!!  Are you sure?');
}

function checkLock(){
    return confirm('Are you sure?  Do u know what are you doing?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>