<?php
$titel = "Support Subject";
$Support = 'active';
include('include/hader.php');
include("conn/connection.php");
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Support' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="SupportSubject" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Complin Subject</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Subject:</div>
						<div class="col-2"><input type="text" name="subject" id="" placeholder="" class="input-large" required=""/></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i> Add Subject</a>
        </div>
        <div class="pageicon"><i class="iconfa-comments-alt"></i></div>
        <div class="pagetitle">
            <h1>Complin Subject</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Subject List
			</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">Subject ID</th>
                            <th class="head1">Subject</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
							$sql = mysql_query("SELECT id, subject FROM `complain_subject` WHERE sts = '0' ORDER BY id DESC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$row['subject']}</b></td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='SupportSubjectEdit?id={$row['id']}' data-original-title='Edit' class='btn ownbtn3' style='padding: 6px 9px;'><i class='iconfa-edit'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='SupportSubjectDelete?id={$row['id']}' data-original-title='Delete' class='btn ownbtn4' style='padding: 6px 9px;' onclick='return checkDelete()'><i class='iconfa-remove'></i></a></li>
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
</script>
<script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>