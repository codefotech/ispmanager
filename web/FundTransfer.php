<?php
$titel = "Fund Transfer";
$FundTransfer = 'active';
include('include/hader.php');
extract($_POST);

ini_alter('date.timezone','Asia/Almaty');
$this_month_yr = date('Y-m', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'FundTransfer' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
?>

	<div class="pageheader">
        <div class="searchbar">
			<?php if($userr_typ == 'mreseller'){} 
		else{ ?>
			<a class="btn ownbtn2" href="FundTransferAdd">Transfer Fund</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Fund Transfer</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Fund Transfers
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">ID</th>
                            <th class="head1">Date</th>
							<th class="head0">Fund Send By</th>
							<th class="head1">Fund Received</th>
							<th class="head0 center">Amount</th>
							<th class="head1">Note</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
					if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'accounts'){
						$sql = mysql_query("SELECT f.id, e.e_id AS send_empid, e.e_name AS send_empname, c.bank_name AS send, c.id AS send_id, w.e_id AS rcv_empid, w.e_name AS rcv_empname, d.bank_name AS rec, d.id AS rec_id, f.transfer_amount, f.transfer_date, DATE_FORMAT(f.transfer_date, '%D %M, %Y') AS transferdate, f.note, DATE_FORMAT(f.last_update, '%h:%i%p') AS last_update FROM fund_transfer AS f
													LEFT JOIN bank AS c ON c.id = f.fund_send
													LEFT JOIN bank AS d ON d.id = f.fund_received
													LEFT JOIN emp_info AS e ON e.e_id = c.emp_id
													LEFT JOIN emp_info AS w ON w.e_id = d.emp_id
													ORDER BY f.id DESC LIMIT 200");
								while( $row = mysql_fetch_assoc($sql) )
								{
									$yrdata1= strtotime($row['transfer_date']);
									$month_yr = date('Y-m', $yrdata1);
									if($this_month_yr == $month_yr){
										$aaaa = "<form action='FundTransferEdit' method='post'><input type='hidden' name='idd' value='{$row['id']}' /><button class='btn ownbtn4' style='padding: 6px 9px;' title='Edit'><i class='iconfa-edit'></i></button></form>";
									}
									else{
										$aaaa = "";
									}
									echo
										"<tr class='gradeX'>
											<td class='center'>{$row['id']}</td>
											<td><b>{$row['transferdate']}</b><br>{$row['last_update']}</td>
											<td>{$row['send']} ({$row['send_id']})<br>{$row['send_empname']} - {$row['send_empid']}</td>
											<td>{$row['rec']} ({$row['rec_id']})<br>{$row['rcv_empname']} - {$row['rcv_empid']}</td>
											<td class='center' style='font-size: 15px;color: #317ebe;'><b>{$row['transfer_amount']} ৳</b></td>
											<td>{$row['note']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li>{$aaaa}</li>
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
</script><script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}

</style>