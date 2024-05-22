<?php
$titel = "SMS Saved Templates";
$SMS = 'active';
include('include/hader.php');
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SMS' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" href="SMSSavedTemplatesAdd">Add</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>SMS Saved Templates</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Templates List
			</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">SMS ID</th>
                            <th class="head1">Template Name</th>
							<th class="head0">Template For</th>
							<th class="head1">SMS Text </th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
						$sql = mysql_query("SELECT id, sms_msg, template_for, template_name FROM `sms_msg` WHERE `saved_template` = '1' AND `sts` = '0'");
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$row['template_name']}</b></td>
											<td>{$row['template_for']}</td>
											<td>{$row['sms_msg']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a href='SMSSavedTemplatesAdd?tempid={$row['id']}' class='btn ownbtn3' title='Edit' style='padding: 6px 9px;'><i class='iconfa-edit'></i></a></li>
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
<script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>