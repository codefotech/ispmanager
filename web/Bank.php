<?php
$titel = "Bank";
$Bank = 'active';
include('include/hader.php');
extract($_POST);


//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Bank' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql = mysql_query("SELECT e.id, e.e_id, e.e_name, d.dept_name FROM bank AS b
					RIGHT JOIN emp_info AS e
					ON e.e_id = b.emp_id
					LEFT JOIN department_info AS d
					ON d.dept_id = e.dept_id

					WHERE ISNULL(b.emp_id) AND e.`status` = '0' AND e.dept_id != '0' ORDER BY e.e_id ASC");
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="BankSave">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Bank Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Bank Name*</div>
						<div class="col-2"><input type="text" name="bank_name" id="" placeholder="Write Name of Bank" class="input-xlarge" required="" /></div>
					</div>
				</div>
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Bank Short Name*</div>
						<div class="col-2"><input type="text" name="sort_name" id="" placeholder="Write Short Name of Bank" class="input-xlarge" required="" /></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn6">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->

	<div class="pageheader">
        <div class="searchbar">
			<?php if($userr_typ == 'mreseller'){} 
		else{ ?>
			<a class="btn ownbtn2" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i> Add Bank</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Bank</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		
	<?php } if($sts == 'bsts') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully <?php echo $aaaa;?> in Your System.			</div><!--alert-->		
	<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Bank List
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
							<th class="head0 center">Bank ID</th>
                            <th class="head1">Bank Name</th>
							<th class="head0">Bank Short Name</th>
							<th class="head1">emp_id</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
					if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'accounts'){
						$sql = mysql_query("SELECT b.id, b.bank_name, b.`sort_name`, b.`emp_id`, e.e_name, b.`show_exp`, b.`sts` FROM `bank` AS b LEFT JOIN emp_info AS e ON e.e_id = b.emp_id ORDER BY b.id ASC ");
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['sts'] == '1'){
										$clss = 'Click to Active';
										$dd = 'iconfa-eye-close';
										$ee = 'ownbtn4';
									}
									if($row['sts'] == '0'){
										$clss = 'Click to Inactive';
										$dd = 'iconfa-eye-open';
										$ee = 'ownbtn2';
									}
									if($row['emp_id'] != ''){
										$empinfo = $row['e_name'].' ('.$row['emp_id'].')';
									}
									else{
										$empinfo = '';
									}
									
//									$queryaaaa = mysql_query("SELECT id AS activeclient, name, online FROM payment_mathod WHERE bank = '$row['id']' AND box_id = '{$row['box_id']}' AND sts = '0'");
//									$rowaaaa = mysql_fetch_assoc($queryaaaa);
									
									echo
										"<tr class='gradeX'>
											<td class='center' style='padding: 10px 0;font-size: 16px;font-weight: bold;color: #555;width: 70px;'>{$row['id']}</td>
											<td><b style='font-weight: bold;font-size: 15px;'>{$row['bank_name']}</b><br>{$row['methdname']}</td>
											<td style='font-weight: bold;padding: 10px 10px;'>{$row['sort_name']}</td>
											<td style='font-weight: bold;padding: 10px 10px;'>{$empinfo}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='BankEdit?id={$row['id']}' data-original-title='Edit Invoice' class='btn ownbtn1' style='padding: 6px 9px;'><i class='iconfa-edit'></i></a></li>
													<li><form action='BankSts' method='post' data-placement='top' data-rel='tooltip' title='{$clss}'><input type='hidden' name='bank_id' value='{$row['id']}' /><input type='hidden' name='bank_sts' value='{$row['sts']}' /><button class='btn {$ee}' style='padding: 6px 9px;' onclick='return checkHide()'><i class='{$dd}'></i></button></form></li>
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
            "aaSortingFixed": [[0,'asc']],
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
</script><script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');} function checkHide(){    return confirm('Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>