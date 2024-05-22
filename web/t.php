<?php
$titel = "Buttons";
$Zone = 'active';
include('include/hader.php');
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Zone' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>


	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Zone</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Zone List
			</div>
			<div class="box-body">
										<table class="table table-bordered table-invoice" style="width: 100%; float: left;margin-right: 3%;">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn1</td>
											<td class="width70" ><a class="btn ownbtn1" href="#"> ownbtn1 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn2</td>
											<td class="width70" ><a class="btn ownbtn2" href="#"> ownbtn2 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn3</td>
											<td class="width70" ><a class="btn ownbtn3" href="#"> ownbtn3 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn4</td>
											<td class="width70" ><a class="btn ownbtn4" href="#"> ownbtn4 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn5</td>
											<td class="width70" ><a class="btn ownbtn5" href="#"> ownbtn5 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn6</td>
											<td class="width70" ><a class="btn ownbtn6" href="#"> ownbtn6 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn7</td>
											<td class="width70" ><a class="btn ownbtn7" href="#"> ownbtn7 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn8</td>
											<td class="width70" ><a class="btn ownbtn8" href="#"> ownbtn8 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn9</td>
											<td class="width70" ><a class="btn ownbtn9" href="#"> ownbtn9 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn10</td>
											<td class="width70" ><a class="btn ownbtn10" href="#"> ownbtn10 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn11</td>
											<td class="width70" ><a class="btn ownbtn11" href="#"> ownbtn11 </a></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;font-size: 20px;">ownbtn12</td>
											<td class="width70" ><a class="btn ownbtn12" href="#"> ownbtn12 </a></td>
										</tr>

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