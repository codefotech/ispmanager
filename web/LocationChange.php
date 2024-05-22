<?php
$titel = "Change Location";
$LocationChange = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'LocationChange' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$queryr = mysql_query("SELECT c_id, c_name, cell FROM clients WHERE mac_user = '0' AND sts = '0' ORDER BY c_name");

$que = mysql_query("SELECT c_id, c_name, cell, address, z_id FROM clients WHERE c_id = '$cid'");
$rows = mysql_fetch_assoc($que);
if($status=='Done')
	{
		$sql = mysql_query("SELECT l.id, e.e_name, l.e_date, l.c_id, l.old_addr, l.new_addr, l.cont, l.shift_date, l.shift_sts FROM line_shift AS l
							LEFT JOIN emp_info AS e ON e.e_id = l.rec_by WHERE l.sts = 0 AND l.shift_sts = 'Done' ORDER BY l.id DESC");
		$tot = mysql_num_rows($sql);
		$tit = "<div class='box-header'><div class='hil'> Total  <i style='color: #317EAC'>{$tot}</i>  Line Shifted Done</div></div>";
	}
if($status=='Done And Cable Remove')
	{
		$sql = mysql_query("SELECT l.id, e.e_name, l.e_date, l.c_id, l.old_addr, l.new_addr, l.cont, l.shift_date, l.shift_sts FROM line_shift AS l
							LEFT JOIN emp_info AS e ON e.e_id = l.rec_by WHERE l.sts = 0 AND l.shift_sts = 'Done And Cable Remove' ORDER BY l.id DESC");
		$tot = mysql_num_rows($sql);
		$tit = "<div class='box-header'><div class='hil'> Total  <i style='color: #317EAC'>{$tot}</i>  Line Shifted Done And Cable Remove</div></div>";
	}
if($status=='Pending')
	{
		$sql = mysql_query("SELECT l.id, e.e_name, l.e_date, l.c_id, l.old_addr, l.new_addr, l.cont, l.shift_date, l.shift_sts FROM line_shift AS l
							LEFT JOIN emp_info AS e ON e.e_id = l.rec_by WHERE l.sts = 0 AND l.shift_sts = 'Pending' ORDER BY l.id DESC");
		$tot = mysql_num_rows($sql);
		$tit = "<div class='box-header'><div class='hil'> Total  <i style='color: #317EAC'>{$tot}</i>  Line Shift Still Pending</div></div>";
	}
if($status=='Not Possible')
	{
		$sql = mysql_query("SELECT l.id, e.e_name, l.e_date, l.c_id, l.old_addr, l.new_addr, l.cont, l.shift_date, l.shift_sts FROM line_shift AS l
							LEFT JOIN emp_info AS e ON e.e_id = l.rec_by WHERE l.sts = 0 AND l.shift_sts = 'Not Possible' ORDER BY l.id DESC");
		$tot = mysql_num_rows($sql);
		$tit = "<div class='box-header'><div class='hil'> Total  <i style='color: #317EAC'>{$tot}</i>  Line Shift Not Possible</div></div>";
	}
if($status=='All')
	{
		$sql = mysql_query("SELECT l.id, e.e_name, l.e_date, l.c_id, l.old_addr, l.new_addr, l.cont, l.shift_date, l.shift_sts FROM line_shift AS l
							LEFT JOIN emp_info AS e ON e.e_id = l.rec_by WHERE l.sts = 0 ORDER BY l.id DESC");
		$tot = mysql_num_rows($sql);
		$tit = "<div class='box-header'><div class='hil'> Total  <i style='color: #317EAC'>{$tot}</i>  Line Shift Clients</div></div>";
	}
if($status=='')
	{
		$sql = mysql_query("SELECT l.id, e.e_name, l.e_date, l.c_id, l.old_addr, l.new_addr, l.cont, l.shift_date, l.shift_sts FROM line_shift AS l
							LEFT JOIN emp_info AS e ON e.e_id = l.rec_by WHERE l.sts = 0 ORDER BY l.id DESC");
		$tot = mysql_num_rows($sql);
		$tit = "<div class='box-header'><div class='hil'> Total  <i style='color: #317EAC'>{$tot}</i>  Line Shift Clients</div></div>";
	}

?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Change Client Location</h5>
				</div>
				<div class="modal-body">
					<div class="row" style="height: 300px;">
						<div class="popdiv">
							<div class="col-1">Client </div>
							<div class="col-2"> 
								<select data-placeholder="Choose Client" name="cid" class="chzn-select"  style="width:280px;" onchange="submit();">
									<option value=""></option>
									<?php while ($row2=mysql_fetch_array($queryr)) { ?>
									<option value="<?php echo $row2['c_id']?>"><?php echo $row2['c_name']; ?> | <?php echo $row2['c_id']; ?> | <?php echo $row2['cell']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->

	<div class="pageheader">
		<div class="searchbar">
			<div class="margillll ">
				<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
					<select data-placeholder="Choose Client" name="status" class="chzn-select" style="width: 170px;" onchange="submit();">
						<option value="All"<?php if ($status == 'All') echo 'selected="selected"';?>>All Status</option>
						<option value="Done"<?php if ($status == 'Done') echo 'selected="selected"';?>>Done</option>
						<option value="Done And Cable Remove"<?php if ($status == 'Done And Cable Remove') echo 'selected="selected"';?>>Done And Cable Remove</option>
						<option value="Pending"<?php if ($status == 'Pending') echo 'selected="selected"';?>>Pending</option>
						<option value="Not Possible"<?php if ($status == 'Not Possible') echo 'selected="selected"';?>>Not Possible</option>
					</select>
				</form>
			</div>
			<a class="btn btn-primary higgggg" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i> Change Location </a>
        </div>
        <div class="pageicon"><i class="iconfa-plane"></i></div>
        <div class="pagetitle">
            <h1>Line Shift</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
	
	<?php if($cid == ''){?>
		<div class="box-header">
			<h5><?php echo $tit; ?></h5>
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
						<col class="con0" />
						
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">S/L</th>
                            <th class="head0">Received</th>
							<th class="head1">Date</th>
							<th class="head0">User ID</th>
							<th class="head1">Current Address</th>
							<th class="head0">New Address</th>
							<th class="head1">Contact</th>
							<th class="head0">Shifing Date</th>
							<th class="head1">Status</th>
                            <th class="head0 center">Action</th>
							
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['shift_sts'] == 'Done'){
										$aa = '';
									}
									else{
										$aa = "<a data-placement='top' data-rel='tooltip' href='LocationChangeEdite?id={$row['id']}' data-original-title='Edit' class='btn col1'><i class='iconfa-edit'></i></a>";
									}
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$row['e_name']}</td>
											<td>{$row['e_date']}</td>
											<td>{$row['c_id']}</td>
											<td>{$row['old_addr']}</td>
											<td>{$row['new_addr']}</td>
											<td>{$row['cont']}</td>
											<td>{$row['shift_date']}</td>
											<td>{$row['shift_sts']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
												<li>{$aa}</li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>	
		<?php }else{?>
					<div class="box-header">
						<div class="modal-content">
							<div class="modal-header">
								<h5>Client Line Shift</h5>
							</div>
								<form id="form" class="stdform" method="POST" action="LocationChangeSave" enctype="multipart/form-data">
									<input type="hidden" name="c_id" value="<?php echo $cid; ?>" />
									<input type="hidden" name="rec_by" value="<?php echo $e_id; ?>" />
									<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
										<div class="modal-body">
											<p>	
												<label>Client Name</label>
												<span class="field"><input type="text" name="c_name" id="" required="" class="input-xxlarge" readonly value="<?php echo $rows['c_name'].' | '.$rows['cell'];?>" /></span>
											</p>
											<label>Zone</label>
											<select name="z_id" class="chzn-select"  style="width:540px;">		
												<?php 
													$queryd="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
													$resultd=mysql_query($queryd);
												while ($rowd=mysql_fetch_array($resultd)) { ?>			
													<option value=<?php echo $rowd['z_id'];?> <?php if ($rowd['z_id'] == $rows['z_id']) echo 'selected="selected"';?> ><?php echo $rowd['z_name'];?> (<?php echo $rowd['z_bn_name'];?>)</option>		
												<?php } ?>
											</select>
											</p>
											<p>
												<label>Old Address</label>
												<span class="field"><textarea type="text" name="old_addr" placeholder="Old Address" id="" class="input-xxlarge" readonly /><?php echo $rows['address'];?></textarea></span>
											</p>
											<p>
												<label>New Address</label>
												<span class="field"><textarea type="text" required=""  name="new_addr" placeholder="New Address........" id="" class="input-xxlarge" /></textarea></span>
											</p>
											<p>
												<label>Shifting Date</label>
												<span class="field"><input type="text" name="shift_date" id="" required="" class="input-xxlarge datepicker" value="<?php echo date('Y-m-d');?>" /></span>
											</p>
											<p>
												<label>Contact</label>
												<span class="field"><input type="text" name="cont" id="" required="" class="input-xxlarge" value="<?php echo $rows['cell'];?>" /></span>
											</p>
											<p>
												<label>Status</label>
												<span class="field">
													<select data-placeholder="Choose a Status" class="chzn-select" name="shift_sts" style="width:540px;" required="" >
														<option value=""></option>
														<option value="Done">Done</option>
														<option value="Done And Cable Remove">Done And Cable Remove</option>																												<option value="Pending">Pending</option>
														<option value="Not Possible">Not Possible</option>
													</select>
												</span>	
											</p>
										</div>
										<div class="modal-footer">
											<button type="reset" class="btn">Reset</button>
											<button class="btn btn-primary" type="submit">Submit</button>
										</div>
								</form>			
						</div>
					</div>
		<?php } ?>
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
			"iDisplayLength": 100,
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
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>