<?php
$titel = "Agent";
$Agent = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Agent' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn3" href="ReportAgentLedger">Ledger</a>
			<a class="btn ownbtn2" href="AgentAdd">ADD AGENT</a>
        </div>
        <div class="pageicon"><i class="iconfa-user-md"></i></div>
        <div class="pagetitle">
            <h1>Agent</h1>
        </div>
    </div><!--pageheader-->		<?php if($sts == 'delete') {?>
	<div class="alert alert-success">	
	<button data-dismiss="alert" class="close" type="button">&times;</button>	
	<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.	
	</div><!--alert-->	
	<?php } if($sts == 'add') {?>	
	<div class="alert alert-success">	
	<button data-dismiss="alert" class="close" type="button">&times;</button>	
	<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.	
	</div><!--alert-->		
	<?php } if($sts == 'edit') {?>	
	<div class="alert alert-success">	
	<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>			
	<div class="box box-primary">
		<div class="box-header">
			<h5>Agent List</h5>
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
							<th class="head1">Agent ID</th>
                            <th class="head0">Agent Name</th>
							<th class="head1">Joning Date</th>
							<th class="head0">Personal Contact</th>
							<th class="head1">Office Contact</th>
							<th class="head1">Commission Percent</th>
							<th class="head0">Email</th>
                            <th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							$sql = mysql_query("SELECT e.e_id, e.e_name, e.com_percent, e.e_cont_per, DATE_FORMAT(e.e_j_date, '%D %M, %Y') AS joining, e.e_cont_office, e.email FROM agent AS e
												WHERE e.status = '0' AND e.z_id = '' ORDER BY e.e_id ASC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									
									echo
										"<tr class='gradeX'>
											<td>{$row['e_id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$row['e_name']}</b></td>
											<td>{$row['joining']}</td>
											<td>{$row['e_cont_per']}</td>
											<td>{$row['e_cont_office']}</td>
											<td><b style='font-weight: bold;font-size: 15px;'>{$row['com_percent']}%</b></td>
											<td>{$row['email']}</td>
											<td class='center' style='width: 115px !important;'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='AgentView?id={$row['e_id']}' style='padding: 6px 9px;' data-original-title='View' class='btn ownbtn2'><i class='fa iconfa-eye-open'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='AgentEdit?id={$row['e_id']}' style='padding: 6px 9px;' data-original-title='Edit' class='btn ownbtn3'><i class='iconfa-edit'></i></a></li>
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
</script><script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>