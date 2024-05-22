<?php
$titel = "Update";
$Update = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Update' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="UpdateAdd"><i class="iconfa-plus"></i> Add Update News</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Application Update News</h1>
        </div>
    </div><!--pageheader-->
		<div class="box box-primary">
			<div class="box-header">
				News List
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
							<th class="head1">Version</th>
							<th class="head0">Subject</th>
                            <th class="head1">Description</th>
							<th class="head0">Update Time</th>
							<th class="head1">Publish Time</th>
							<th class="head0">Update by</th>
							<th class="head1">New?</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							$sql = mysql_query("SELECT id, version, update_subject, update_desc, update_time, update_by, publish_time, new, position FROM updates WHERE status = '0' ORDER BY id desc");
								while( $row = mysql_fetch_assoc($sql) )
								{
									
									echo
										"<tr class='gradeX'>
											<td>{$row['version']}</td>
											<td>{$row['update_subject']}</td>
											<td>{$row['update_desc']}</td>
											<td>{$row['update_time']}</td>
											<td>{$row['publish_time']}</td>
											<td>{$row['update_by']}</td>
											<td>{$row['new']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='UpdateEdit?id=",$id,"{$row['id']}' data-original-title='Edit Invoice' class='btn col1'><i class='iconfa-edit'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='UpdateDelete?id=",$id,"{$row['id']}' data-original-title='Delete Employee' class='btn col5' onclick='return checkDelete()'><i class='iconfa-trash'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
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
</script>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>