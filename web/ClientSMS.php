<?php
$titel = "SMS";
$SMS = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$ids = $_GET['id'];
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SMS' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql = ("SELECT c.c_name, c.z_id, c.c_id, z.z_name, c.cell, c.email, c.address, c.join_date, c.opening_balance, c.con_type, c.cable_sts, c.discount, c.con_sts, c.req_cable, c.cable_type, c.nid, c.p_id, p.p_name, c.signup_fee, c.note FROM clients AS c
		LEFT JOIN zone AS z
		ON z.z_id = c.z_id
		LEFT JOIN package AS p
		ON p.p_id = c.p_id WHERE c_id ='$ids' ");
		
$query = mysql_query($sql);
$row = mysql_fetch_assoc($query);
		$cname= $row['c_name'];
		$z_id= $row['z_id'];
		$cid= $row['c_id'];
		$z_name = $row['z_name'];
		$occupation = $row['occupation'];
		$cellr= $row['cell'];
		$opening_balance = $row['opening_balance'];
		$email= $row['email'];
		$address= $row['address'];
		$previous_isp= $row['previous_isp'];
		$join_date= $row['join_date'];
		$con_type= $row['con_type'];
		$cable_sts= $row['cable_sts'];
		$con_sts= $row['con_sts'];
		$req_cable= $row['req_cable'];
		$cable_type= $row['cable_type'];
		$nid= $row['nid'];
		$p_id= $row['p_id'];
		$signup_fee= $row['signup_fee'];
		$note= $row['note'];
		$discount = $row['discount'];
?>
<script>
      function countChar(val) {
        var len = val.value.length;
        if (len >= 1080) {
          val.value = val.value.substring(0, 1080);
        } else {
          $('#charNum').text(1080 - len);
        }
      };
</script>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="SMS"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-comment"></i></div>
        <div class="pagetitle">
            <h1>SMS To <?php echo $c_name;?><?php echo $cname;?></h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Write SMS for <?php echo $c_name;?><?php echo $cname;?></h5>
				</div>
					<div class="popdiv">
							<form id="form2" class="stdform" method="post" action="ClientSMSSent">
									<input type='hidden' name='smsway' value='duebill'/> 
									<input type='hidden' name='c_id' value='<?php echo $cid;?><?php echo $c_id;?>'/> 
									<input type='hidden' name='cell' value='<?php echo $cellr;?><?php echo $cell;?>'/> 
									<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
								<button class="btn btn-primary" type="submit" style="float: left;margin-right: 1%;">Due Bill</button>
							</form>
							<form id="form2" class="stdform" method="post" action="ClientSMSSent">
									<input type='hidden' name='smsway' value='1remainder'/> 
									<input type='hidden' name='c_id' value='<?php echo $cid;?><?php echo $c_id;?>'/> 
									<input type='hidden' name='cell' value='<?php echo $cellr;?><?php echo $cell;?>'/> 
									<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
								<button class="btn btn-primary" type="submit" style="float: left;margin-right: 1%;">1st Remainder</button>
							</form>
							<form id="form2" class="stdform" method="post" action="ClientSMSSent">
									<input type='hidden' name='smsway' value='2remainder'/> 
									<input type='hidden' name='c_id' value='<?php echo $cid;?><?php echo $c_id;?>'/> 
									<input type='hidden' name='cell' value='<?php echo $cellr;?><?php echo $cell;?>'/> 
									<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
								<button class="btn btn-primary" type="submit" style="float: left;">2nd Remainder</button>
							</form>
					</div>
			
					<form id="form" class="stdform" method="post" action="ClientSMSSent">
						<input type='hidden' name='c_id' value='<?php echo $c_id;?><?php echo $cid;?>'/> 
						<input type='hidden' name='smsway' value='write'/> 
						<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
							<div class="modal-body">
								<p>
									<label>Phone No*</label>
									<span class="field"><input type="text" name="cell" id="" readonly required="" class="input-xxlarge" value="<?php echo $cell;?><?php echo $cellr;?>" /></span>

								</p>
								<p>
									<label>SMS Text</label>
									<span class="field"><textarea type="text" maxlength="1080" required="" name="sms_body" placeholder="Max 1080" id="" onkeyup="countChar(this)" class="input-xxlarge" />Dear <?php echo $c_name;?><?php echo $cname;?>,</textarea></span>
								</p>
								<span class="field"><div id="charNum"></div></span>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
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