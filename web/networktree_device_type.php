<?php 
include("conn/connection.php");
$type=$_GET['type'];
$treeid=$_GET['tree_id'];
$result11=mysql_query("SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC");

$result133=mysql_query("SELECT ip, mk_id FROM network_tree WHERE tree_id = '$treeid'");
$row133=mysql_fetch_assoc($result133);

if($type == '4' || $type == '6' || $type == '8'){
?>
						<p>	
							<label style="font-weight: bold;">Network*</label>
							<select data-placeholder="Choose a Network..." name="mk_id" class="chzn-select" style="width:20%;" required="">
								<option value=""></option>
									<?php while ($row11=mysql_fetch_array($result11)) { ?>
								<option value=<?php echo $row11['id'];?> <?php if ($row11['id'] == $row133['mk_id']) echo 'selected="selected"';?> ><?php echo $row11['Name'];?> (<?php echo $row11['ServerIP'];?>)</option>		
									<?php } ?>
							</select>
						</p>
						<p>
                            <label>Check Ping?</label>
							<span class="formwrapper">
								<input type="radio" name="ping" value="1" onChange="getRoutePoint2(this.value)"> Yes &nbsp; &nbsp;
								<input type="radio" name="ping" value="0" onChange="getRoutePoint2(this.value)" checked="checked"> No &nbsp; &nbsp;
                            </span>
                        </p>
<div id="Pointdiv2">
						<p>
							<label>Device Local IP</label>
							<span class="field"><input type="text" name="ip" value="<?php echo $row133['ip'];?>" id="" style="width:15%;"/></span>
						</p>
</div>
<?php } else {}?>