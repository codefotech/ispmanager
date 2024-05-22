<?php
$titel = "Edit Box Information";
$Zone = 'active';
include('include/hader.php');
$box_id = $_GET['id'];
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Zone' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql2 ="SELECT * FROM box WHERE box_id = '$box_id'";

$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$boxid = $row2['box_id'];
$boxname = $row2['b_name'];
$location = $row2['location'];
$b_port = $row2['b_port'];
$z_id = $row2['z_id'];
$onu = $row2['onu'];
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
		<?php if($userr_typ == 'mreseller'){?>
			<h1>Edit Zone</h1>
		<?php } else{?>
            <h1>Edit Box|Sub-Zone</h1>
		<?php } ?>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<?php if($user_type == 'mreseller'){ ?><h5> Zone Information Edit </h5><?php } else {?> Box Information Edit <?php } ?>
				</div>
				<form id="form" class="stdform" method="post" action="BoxEditQuery" >
					<div class="modal-body">
					<p>
						<?php if($user_type == 'mreseller'){ ?><label>Zone ID</label><?php } else {?><label>Box ID</label><?php } ?>
						<span class="field">
							<div class="controls">	
								<input style="text-align:center;" id="" type="text" class="input-xlarge" readonly name="box_id" value="<?php echo $boxid;?>">
							</div>
						</span>
					</p>
					<?php if($user_type == 'mreseller'){ ?>
						<input type="hidden" class="input-xlarge" name="way" value="reseller">
						<input type="hidden" class="input-xlarge" name="z_id" value="<?php echo $macz_id;?>">
					<p>
						<label style="font-weight: bold;">Zone Name*</label>
						<span class="field"><input id="" type="text" name="b_name" class="input-xlarge" value="<?php echo $boxname;?>" required=""></span>
					</p>
					<?php } else {?>
						<input type="hidden" class="input-xlarge" name="way" value="notreseller">
					<p>
						<label style="font-weight: bold;">Zone*</label>
						<select name="z_id" class="chzn-select"  style="width:280px;" required="">		
							<?php 
								$queryd="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
									$resultd=mysql_query($queryd);
								while ($rowd=mysql_fetch_array($resultd)) { ?>			
											<option value=<?php echo $rowd['z_id'];?> <?php if ($rowd['z_id'] == $z_id) echo 'selected="selected"';?> ><?php echo $rowd['z_name'];?> (<?php echo $rowd['z_bn_name'];?>)</option>		
							<?php } ?>
						</select>
					</p>
					<p>
						<label style="font-weight: bold;">Box Name*</label>
						<span class="field"><input id="" type="text" name="b_name" class="input-xlarge" value="<?php echo $boxname;?>"></span>
					</p>
					<?php } ?>
					
					<p>
						<label>Location</label>
						<span class="field"><input id="" type="text" name="location" class="input-xlarge" value="<?php echo $location;?>"></span>
					</p>
					<p>
						<label>Port</label>
						<span class="field"><input id="" type="text" name="b_port" class="input-xlarge" value="<?php echo $b_port;?>"></span>
					</p>
					<p>
						<label>Onu</label>
						<span class="field"><input id="" type="text" name="onu" class="input-xlarge" value="<?php echo $onu;?>"></span>
					</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>			
			</div>
		</div>
	</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>