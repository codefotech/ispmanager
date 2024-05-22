<?php
$titel = "Edit Network Information";
$Network = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$que = mysql_query("SELECT id, Name, ServerIP, Username, Port, note, secret_h, graph, web_port, auto_sync_sts, auto_client_mk_sts, tx_rx_count_sts FROM mk_con WHERE sts = '0' AND id = '$n_id'");
$row2 = mysql_fetch_assoc($que);
$mk_id = $row2['id'];
$ServerIP = $row2['ServerIP'];
$Username = $row2['Username'];
$Port = $row2['Port'];
$note = $row2['note'];
$secret_h = $row2['secret_h'];
$Name = $row2['Name'];
$graph = $row2['graph'];
$web_port = $row2['web_port'];
$auto_sync_sts = $row2['auto_sync_sts'];
$auto_client_mk_sts = $row2['auto_client_mk_sts'];
$tx_rx_count_sts = $row2['tx_rx_count_sts'];

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-rss"></i></div>
        <div class="pagetitle">
            <h1>Edit Mikrotik</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Mikrotik Information </h5>
				</div>
				<form id="form" class="stdform" method="post" action="NetworkEditQuery">
				<input type="hidden" name="mk_id" value="<?php echo $mk_id; ?>"/>
				<input type="hidden" name="secret_h" value="<?php echo $secret_h; ?>"/>
				<input type="hidden" name="edit_by" value="<?php echo $e_id; ?>"/>
				<input type="hidden" name="edit_date_time" value="<?php echo date("Y-m-d H:i:s");?>"/>
				
					<div class="modal-body">
					<p>
						<label style="font-weight: bold;">Network Name*</label>
						<span class="field"><input style="text-align:center;" id="" type="text" class="input-xlarge" required="" name="Name" value="<?php echo $Name;?>"></span>
					</p>
					<p>
						<label style="font-weight: bold;">Public IP*</label>
						<span class="field"><input style="text-align:center;" id="" type="text" name="ServerIP" class="input-xlarge" required="" value="<?php echo $ServerIP;?>"></span>
					</p>
					<p>
						<label style="font-weight: bold;">Login*</label>
						<span class="field"><input style="text-align:center;" id="" type="text" name="mk_username" class="input-xlarge" required="" value="<?php echo $Username;?>"></span>
					</p>
					<p>
						<label style="font-weight: bold;">Password*</label>
						<span class="field"><input style="text-align:center;" type="password" name="mk_pass" class="input-xlarge" placeholder="Mikrotik Password" size="12" required="" /></span>
					</p>
					<?php if($user_type == 'superadmin'){?>
					<p>
						<label style="font-weight: bold;color:red;">Bandwidth Count</label>
						<span class="formwrapper"  style="margin-left: 0px;">
							<input type="radio" name="tx_rx_count_sts" value="1" <?php if('1' == $tx_rx_count_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
							<input type="radio" name="tx_rx_count_sts" value="0" <?php if('0' == $tx_rx_count_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
						</span>
					</p>
					<?php } else{ ?>
						<input type="hidden" name="tx_rx_count_sts" value="<?php echo $tx_rx_count_sts; ?>"/>
					<?php } ?>
					<p>
						<label>Auto MK Sync?</label>
						<span class="formwrapper"  style="margin-left: 0px;">
							<input type="radio" name="auto_client_mk_sts" value="1" <?php if('1' == $auto_client_mk_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
							<input type="radio" name="auto_client_mk_sts" value="0" <?php if('0' == $auto_client_mk_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
						</span>
					</p>
					<p>
						<label>Auto Sync</label>
						<span class="formwrapper"  style="margin-left: 0px;">
							<input type="radio" name="auto_sync_sts" value="1" <?php if('1' == $auto_sync_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
							<input type="radio" name="auto_sync_sts" value="0" <?php if('0' == $auto_sync_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
						</span>
					</p>
					<p>
						<label>Active Graph?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>If Yes, You Require Web Port</i></a></label>
						<span class="formwrapper"  style="margin-left: 0px;">
							<input type="radio" name="graph" value="1" <?php if('1' == $graph) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
							<input type="radio" name="graph" value="0" <?php if('0' == $graph) echo 'checked="checked"';?>> No &nbsp; &nbsp;
						</span>
					</p>
					<br>
					<p>
						<label style="font-weight: bold;">Web Port No</label>
						<span class="field"><input style="text-align:center;" id="" type="text" name="web_port" class="input-large" value="<?php echo $web_port;?>"></span>
					</p>
					<p>
						<label>Note</label>
						<span class="field"><textarea type="text" name="note" id="" class="input-xlarge"/><?php echo $note;?></textarea></span>
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