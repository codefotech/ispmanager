<?php
$titel = "Instruments Store In";
$Store = 'active';
include('include/hader.php');
$pid = $_GET['pid'];
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(189, $access_arry)){
//---------- Permission -----------

$result1y = mysql_query("SELECT SUM(quantity) AS totaqty, SUM(price) AS totalprice FROM store_in_instruments WHERE p_id = '$pid'");
$row2226 = mysql_fetch_assoc($result1y);

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<a class="btn ownbtn2" href="Instruments">Instruments Details</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h3>Instruments In Details</h3>
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
				<h4><b><?php if($pid == ''){?> Instruments Summary <?php } else{ echo 'Total In Quantity: '.$row2226['totaqty'].' pieces & Total Price: '.$row2226['totalprice'].' ৳'; }?></b></h4>
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
							<th class="head0 center">S/L</th>
							<th class="head1 center">Buy Date/Purchaser</th>
							<th class="head0">Item/Brand/Vendor</th>
							<th class="head1 center">Qty</th>
							<th class="head0 center">Price</th>
							<th class="head0">S/L & Note</th>
							<th class="head0 center">Entry By</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if($pid == ''){
							$sql = mysql_query("SELECT i.id, i.purchase_date, DATE_FORMAT(i.purchase_date, '%D %M, %Y') AS entrytime, p.sl_sts, i.in_id, i.voucher_no, i.purchase_by, e.e_name AS purchaseby, i.vendor, v.v_name, i.p_sts, i.p_sl_no, i.p_id, p.pro_name, i.brand, i.quantity, i.price, i.rimarks, i.entry_by, a.e_name AS entryby, DATE_FORMAT(i.entry_time, '%D %M, %Y %r') AS entry_time, i.sts FROM store_in_instruments AS i
													LEFT JOIN emp_info AS e
													ON e.e_id = i.purchase_by
													LEFT JOIN vendor AS v
													ON v.id = i.vendor
													LEFT JOIN product AS p
													ON p.id = i.p_id
													LEFT JOIN emp_info AS a
													ON a.e_id = i.entry_by
													ORDER BY i.purchase_date");
								$x = 1;	
						}
						else{
							$sql = mysql_query("SELECT i.id, i.purchase_date, DATE_FORMAT(i.purchase_date, '%D %M, %Y') AS entrytime, p.sl_sts, i.in_id, i.voucher_no, i.purchase_by, e.e_name AS purchaseby, i.vendor, v.v_name, i.p_sts, i.p_sl_no, i.p_id, p.pro_name, i.brand, i.quantity, i.price, i.rimarks, i.entry_by, a.e_name AS entryby, DATE_FORMAT(i.entry_time, '%D %M, %Y %r') AS entry_time, i.sts FROM store_in_instruments AS i
													LEFT JOIN emp_info AS e
													ON e.e_id = i.purchase_by
													LEFT JOIN vendor AS v
													ON v.id = i.vendor
													LEFT JOIN product AS p
													ON p.id = i.p_id
													LEFT JOIN emp_info AS a
													ON a.e_id = i.entry_by
													WHERE i.p_id = '$pid' ORDER BY i.purchase_date");
								$x = 1;	
						}
								while( $row = mysql_fetch_assoc($sql) )
								{									
								if(in_array(193, $access_arry)){
									
									if($row['rimarks'] != ''){
										$noteeeeeeee = '<b>NOTE: </b>'.$row['rimarks'];
									}
									else{
										$noteeeeeeee = '';
									}
								if($row['sl_sts'] == '1'){
									$sqddlff = mysql_query("SELECT COUNT(id) AS outcount FROM store_instruments_sl WHERE sts = '0' AND out_sts = '1' AND in_id = '{$row['in_id']}' AND p_id = '{$row['p_id']}'");
									$rowwdsd = mysql_fetch_assoc($sqddlff);
									$sloutcount = $rowwdsd['outcount'];
									
									$sqddl = mysql_query("SELECT id, p_id, GROUP_CONCAT(slno SEPARATOR ',') AS slno, in_id, out_sts, sts FROM store_instruments_sl WHERE in_id = '{$row['in_id']}' AND p_id = '{$row['p_id']}'");
									$rowwdd = mysql_fetch_assoc($sqddl);
									$slno = $rowwdd['slno'];
									
									if($sloutcount > 0){
										$delnow = "";
									}
									else{
										$delnow = "<ul class='tooltipsample'>
													<li><form action='StoreInDelete' method='post'><input type='hidden' name='id' value='{$row['id']}'/>
													<input type='hidden' name='store_type' value='instruments'/>
													<input type='hidden' name='e_id' value='{$e_id}'/>
													<input type='hidden' name='entryby' value='{$row['entryby']}'/>
													<input type='hidden' name='entry_by' value='{$row['entry_by']}'/>
													<input type='hidden' name='p_id' value='{$row['p_id']}'/>
													<input type='hidden' name='quantity' value='{$row['quantity']}'/>
													<input type='hidden' name='in_id' value='{$row['in_id']}'/>
													<input type='hidden' name='wayyyy' value='withsl'/>
													<button class='btn ownbtn4' style='padding: 6px 9px;' title='Delete' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form></li>
												</ul>";
									}
								}
								else{
									$slno = "";
									
									$delnow = "<ul class='tooltipsample'>
													<li><form action='StoreInDelete' method='post'><input type='hidden' name='id' value='{$row['id']}'/>
													<input type='hidden' name='store_type' value='instruments'/>
													<input type='hidden' name='e_id' value='{$e_id}'/>
													<input type='hidden' name='entryby' value='{$row['entryby']}'/>
													<input type='hidden' name='entry_by' value='{$row['entry_by']}'/>
													<input type='hidden' name='p_id' value='{$row['p_id']}'/>
													<input type='hidden' name='quantity' value='{$row['quantity']}'/>
													<input type='hidden' name='wayyyy' value='notsl'/>
													<button class='btn ownbtn4' style='padding: 6px 9px;' title='Delete' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form></li>
												</ul>";
								}
									
								echo
										"<tr class='gradeX'>
											<td class='center' style='font-weight: bold;padding: 20px 5px;'>{$row['id']}</td>
											<td class='center'><b>{$row['entrytime']}</b><br>by<br>[{$row['purchaseby']}]</td>
											<td><b style='font-size: 14px;color: brown;'>{$row['pro_name']}</b><br>{$row['brand']}<br><b>{$row['v_name']}</b><br>Voucher: {$row['voucher_no']}</td>
											<td class='center' style='padding: 20px 0px;font-size: 20px;color: #c30fdd;'><b>{$row['quantity']}</b></td>
											<td class='center' style='padding: 20px 0px;font-size: 16px;color: teal;'><b>{$row['price']}</b></td>
											<td style='max-width: 250px;'>{$slno}<br><br>{$noteeeeeeee}</td>
											<td class='center'>{$row['entryby']} ({$row['purchase_by']})<br>at<br>{$row['entry_time']}</td>
											<td class='center'>{$delnow}</td>
										</tr>\n";
										$x++;	
								}  
								else{
									echo
										"<tr class='gradeX'>
											<td class='center' style='font-weight: bold;padding: 20px 5px;'>{$row['id']}</td>
											<td class='center'><b>{$row['entrytime']}</b><br>by<br>[{$row['purchaseby']}]</td>
											<td><b style='font-size: 14px;color: brown;'>{$row['pro_name']}</b><br>{$row['brand']}<br><b>{$row['v_name']}</b><br>Voucher: {$row['voucher_no']}</td>
											<td class='center' style='padding: 20px 0px;font-size: 20px;color: #c30fdd;'><b>{$row['quantity']}</b></td>
											<td class='center' style='padding: 20px 0px;font-size: 16px;color: teal;'><b>{$row['price']}</b></td>
											<td style='max-width: 250px;'>{$row['p_sl_no']}<br><br>{$noteeeeeeee}</td>
											<td class='center'>{$row['entryby']} ({$row['purchase_by']})<br>at<br>{$row['entry_time']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													
												</ul>
											</td>
										</tr>\n ";
										$x++;
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
<style>
#dyntable_length{display: none;}
</style>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
</script>