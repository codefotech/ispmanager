<?php
$titel = "Employee";
$Employee = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Employee' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn5" href="Salary"><i class="iconfa-money"></i> Salary</a>
			<a class="btn ownbtn3" href="Department"><i class="iconfa-th-large"></i> Department</a>
			<a class="btn ownbtn2" href="EmployeeAdd"><i class="iconfa-plus"></i> Add Employee</a>
        </div>
        <div class="pageicon"><i class="iconfa-user-md"></i></div>
        <div class="pagetitle">
            <h1>Employee</h1>
        </div>
    </div><!--pageheader-->		<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>			
	<div class="box box-primary">
		<div class="box-header">
			<h5>Employee List</h5>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">Employee ID</th>
                            <th class="head0">Employee Name</th>
							<th class="head1">Designation</th>
							<th class="head0">Department</th>
							<th class="head1">Joning Date</th>
							<th class="head0">Personal Contact</th>
							<th class="head1">Office Contact</th>
							<th class="head0">Email</th>
                            <th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							$sql = mysql_query("SELECT e.id, e.e_id, e.e_name, e.e_des, d.dept_name, e.e_cont_per, e.e_j_date, e.e_cont_office, e.email  FROM emp_info AS e
												LEFT JOIN department_info AS d ON e.dept_id = d.dept_id	WHERE e.status = '0' AND e.z_id = '' ORDER BY e.e_id DESC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['e_id']}</td>
											<td>{$row['e_name']}</td>
											<td>{$row['e_des']}</td>
											<td>{$row['dept_name']}</td>
											<td>{$row['e_j_date']}</td>
											<td>{$row['e_cont_per']}</td>
											<td>{$row['e_cont_office']}</td>
											<td>{$row['email']}</td>
											<td class='center' style='width: 115px !important;'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='EmployeeView?id={$row['e_id']}' data-original-title='View Employee' class='btn ownbtn2' style='padding: 6px 9px;'><i class='fa iconfa-eye-open'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='EmployeeEdit?id={$row['e_id']}' data-original-title='Edit Employee' class='btn ownbtn3' style='padding: 6px 9px;'><i class='iconfa-edit'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='EmployeeDelete?id={$row['id']}' data-original-title='Delete Employee' class='btn ownbtn4' style='padding: 6px 9px;' onclick='return checkDelete()'><i class='iconfa-trash'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
			</div>			
	</div>

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
				

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