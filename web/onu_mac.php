<?php 
include("conn/connection.php");
include("company_info.php");
$cable_type=$_GET['cable_type'];
$cid=$_GET['c_id'];

$sqlsdf = mysql_query("SELECT n.tree_id, n.parent_id, n.out_port, n.in_port, n.latitude, n.longitude, n.in_color, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, t.name AS sourcename, n.location, z.z_id, z.z_name, c.onu_mac, c.c_name, n.c_id FROM network_tree AS n 
												LEFT JOIN device AS d ON d.id = n.device_type
												LEFT JOIN zone AS z ON z.z_id = n.z_id
												LEFT JOIN network_tree AS t ON t.tree_id = n.parent_id
												LEFT JOIN clients AS c ON c.c_id = n.c_id
												WHERE n.sts = '0' AND n.device_sts = '0' AND n.c_id = '$cid'");
$rowc1 = mysql_fetch_assoc($sqlsdf);

$sqlc1 = mysql_query("SELECT onu_mac FROM clients WHERE c_id = '$cid'");
$rowc1sss = mysql_fetch_assoc($sqlc1);

if($cable_type == 'FIBER' && $client_use_diagram_client == '0'){ ?>
<input type="hidden" style="width:240px;" name="diagram_way" class="input-xlarge" value="<?php echo $client_use_diagram_client;?>"/>
<p>
	<label style="width: 130px;font-weight: bold;">ONU MAC*</label>
	<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="onu_mac" value="<?php echo $rowc1sss['onu_mac'];?>" placeholder="Ex: A1:B2:C3:EF:G5:67" class="input-xlarge" required=""/></span>
</p>

<?php } elseif($cable_type == 'FIBER' && $client_use_diagram_client == '1'){ ?>
<div style="border:1px solid #bbbbbb70;">
						<center><b style="color: #ff0000b8;">..............::::::::::[ Network Diagram Informations ]::::::::::..............</b></center>
						<input type="hidden" style="width:240px;" name="diagram_way" class="input-xlarge" value="<?php echo $client_use_diagram_client;?>"/>
						<p>
							<label style="width: 130px;font-weight: bold;">ONU MAC</label>
							<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" placeholder="Ex: A1:B2:C3:EF:G5:67" name="onu_mac" value="<?php echo $rowc1sss['onu_mac'];?>" class="input-xlarge"/></span>
						</p>
						<p>	
						<label style="width: 130px;font-weight: bold;">LineIn Source*</label>
						<select class="select-ext-large chzn-select" style="width:250px;" name="parent_id" required="" >
								<option value="">Choose Source</option>
								<?php $insorce=mysql_query("SELECT n.tree_id, n.parent_id, n.out_port, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, n.location, z.z_id, z.z_name FROM network_tree AS n 
												LEFT JOIN device AS d ON d.id = n.device_type
												LEFT JOIN zone AS z ON z.z_id = n.z_id
												WHERE n.sts = '0' AND n.device_sts = '0' AND n.device_type = '2' or n.device_type = '3' or n.device_type = '6' or n.device_type = '8' ORDER BY n.tree_id ASC");
										while ($enr=mysql_fetch_array($insorce)) { ?>
								<option value="<?php echo $enr['tree_id'];?>"<?php if ($enr['tree_id'] == $rowc1['parent_id']) echo 'selected="selected"';?>><?php echo $enr['tree_id'];?> - <?php echo $enr['name'];?> ( <?php echo $enr['d_name'];?> - <?php echo $enr['out_port'];?> )</option>
								<?php } ?>
							</select>
						</p>
						<p>
							<label style="width: 130px;font-weight: bold;">Source Core Color*</label>
							<span class="field" style="margin-left: 0px;"><input type="text" name="in_color" id="" style="width:240px;" required="" value="<?php echo $rowc1['in_color'];?>" placeholder="Ex: Blue, Red etc" /></span>
						</p>
						<p>
							<label style="width: 130px;font-weight: bold;">Source Core No*</label>
							<span class="field" style="margin-left: 0px;"><input type="text" name="in_port" id="" style="width:15%;" value="<?php echo $rowc1['in_port'];?>" required=""/></span>
						</p>
						<p>
							<label style="width: 130px;">Fiber Code</label>
							<span class="field" style="margin-left: 0px;"><input type="text" name="fiber_code" id="" value="<?php echo $rowc1['fiber_code'];?>" style="width:15%;"/></span>
						</p>
</div>
<?php }else{ ?>
	<input type="hidden" name="onu_mac" class="input-xlarge" value="" required=""/>
<?php } ?>