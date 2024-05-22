<?php
$titel = "Vendor Payment";
$VendorPayment = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'VendorBill' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
?>

	<div class="pageheader">
        <div class="searchbar">
			<?php if($userr_typ == 'mreseller'){} 
		else{ ?>
			<a class="btn btn-primary" href="VendorPaymentAdd"><i class="iconfa-plus"></i> Vendor Payment</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Vendor Payment</h1>
        </div>
    </div><!--pageheader-->	
	<?php if($sts == 'delete') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted from Your System.
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
	<?php } ?>		
	
		<div class="box box-primary">
			<div class="box-header">
				Vendor Payments
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
							<th class="head0">Date</th>
                            <th class="head1">Vendor Name/Cell/Address</th>
							<th class="head0">Amount</th>
							<th class="head1">Mathod</th>
							<th class="head0">Paid Bank</th>
							<th class="head1">Entry By</th>
							<th class="head0">Note</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
					if($user_type == 'admin' || $user_type == 'superadmin'){
						$sql = mysql_query("SELECT p.id AS vp_id, p.payment_date, p.mathod, p.ck_trx_no, p.v_id, v.v_name, v.cell, v.location, p.note, p.bank, b.bank_name, p.amount, p.ent_by, e.e_name, p.sts FROM `vendor_payment` AS p
											LEFT JOIN vendor AS v ON v.id = p.v_id
											LEFT JOIN bank AS b ON b.id = p.bank
											LEFT JOIN emp_info AS e ON e.e_id = p.ent_by
											WHERE p.sts = '0' ORDER BY p.id DESC LIMIT 200");
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['payment_date']}</td>
											<td>{$row['v_name']}<br>{$row['cell']}<br>{$row['location']}</td>
											<td>{$row['amount']}</td>
											<td>{$row['mathod']}<br>{$row['ck_trx_no']}</td>
											<td>{$row['bank_name']}</td>
											<td>{$row['e_name']}</td>
											<td>{$row['note']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><form action='VendorPaymentDelete' method='post'><input type='hidden' name='vp_id' value='{$row['vp_id']}' /><input type='hidden' name='e_id' value='{$e_id}' /><button class='btn col5' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
								}
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
			"iDisplayLength": 20,
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
</script><script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}

</style>