<?php
$titel = "Box";
$Zone = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Zone' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($user_type == 'billing'){
$querydd="SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name";
}
else{
$querydd="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
}
$resultdd=mysql_query($querydd);
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="way" value="notreseller" />
	<input type="hidden" name="typ" value="BoxAdd" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Sub-Zone | Box Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Zone*</div>
						<div class="col-2">
							<select data-placeholder="Choose Your Area..." name="z_id" class="chzn-select" style="width:220px;" required="">
								<option value=""></option>
										<?php while ($rowdd=mysql_fetch_array($resultdd)) { ?>
								<option value="<?php echo $rowdd['z_id']?>"><?php echo $rowdd['z_name']; ?> (<?php echo $rowdd['z_bn_name']; ?>)</option>
											<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Name*</div>
						<div class="col-2"><input type="text" name="b_name" id="" placeholder="Ex: Sub-Zone | Box Name" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Location</div>
						<div class="col-2"><input type="text" name="location" id="" placeholder="Ex: Sub-Zone | Box Address" class="input-large" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Total Port</div>
						<div class="col-2"><input type="text" name="b_port" id="" placeholder="Ex: like 8" class="input-large"/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Onu</div>
						<div class="col-2"><input type="text" name="onu" id="" placeholder="Onu Details" class="input-large"/></div>
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
			<a class="btn ownbtn2" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i> Add Box</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Sub-Zone | Box</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Sub-Zone | Box List
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
							<th class="head0">Box ID</th>
                            <th class="head1">Box Name</th>
							<th class="head0">Location</th>
							<th class="head1">Onu</th>
							<th class="head0">Port</th>
							<th class="head1">Zone</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
							$sql = mysql_query("SELECT b.box_id, b.b_name, b.onu, b.location, b.b_port, z.z_name, z.z_id FROM box AS b LEFT JOIN zone AS z ON z.z_id = b.z_id WHERE b.sts = '0' AND z.e_id = '' ORDER BY b.box_id DESC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND box_id = '{$row['box_id']}' AND sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$activeclient = $rowaaaa['activeclient'];
									
									$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND box_id = '{$row['box_id']}' AND sts = '0'");
									$rowiii = mysql_fetch_assoc($queryiiiii);

									$inactiveclient = $rowiii['inactiveclient'];
									
									$totalclients = $activeclient + $inactiveclient;
									if($totalclients == '0'){
										$aaa = "<form action='BoxDelete' method='post' style='margin-top: 8px;' onclick='return checkDelete()'><input type='hidden' name='box_id' value='{$row['box_id']}'/><input type='hidden' name='e_id' value='{$e_id}'/><input type='hidden' name='way' value='notreseller'/><button class='btn ownbtn4' style='padding: 6px 9px;' title='Delete'><i class='iconfa-trash'></i></button></form>";
									}
									else{
										$aaa = '';
									}
									echo
										"<tr class='gradeX'>
											<td>{$row['box_id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$row['b_name']}</b><br><b style='color: #00a65a;font-weight: bold;'>Active:</b> {$activeclient}<br><b style='color: #b94a48;font-weight: bold;'>Inactive:</b> {$inactiveclient}<br><b style='font-weight: bold;'>Total:</b> {$totalclients}</td>
											<td>{$row['location']}</td>
											<td>{$row['onu']}</td>
											<td>{$row['b_port']}</td>
											<td>{$row['z_name']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a href='Clients?id=all&zid={$row['z_id']}&boxid={$row['box_id']}' class='btn ownbtn2' title='Check All Clients' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></a></li>
													<li><form action='BoxEdit' method='post' style='margin-top: 8px;'><input type='hidden' name='box_id' value='{$row['box_id']}'/><button class='btn ownbtn3' style='padding: 6px 9px;' title='Edit'><i class='iconfa-edit'></i></button></form></li>
													<li>{$aaa}</li>
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
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[5,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>