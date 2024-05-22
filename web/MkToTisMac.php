<?php
$titel = "Choose Reseller";
$Network = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$resultsdfg=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by e.e_name");
?>

	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Add Mac Reseller Client in Application</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content" style="min-height: 250px;">
				<div class="modal-header">
					<h5>Choose Reseller and Area</h5>
				</div>
				<?php if($limit_accs == 'Yes'){ ?>
					<form id="form2" class="stdform" method="post" action="MACClientAdd1">
						<input type='hidden' name='wayyyyyy' value='mktomac'/> 
						<input type='hidden' name='mk_id' value='<?php echo $mk_id;?>'/> 
						<input type='hidden' name='c_id' value='<?php echo $c_id;?>'/> 
						<input type='hidden' name='c_name' value='<?php echo $c_name;?>'/> 
						<input type='hidden' name='passid' value='<?php echo $passid;?>'/>
						<input type='hidden' name='mk_profile' value='<?php echo $mk_profile;?>'/>
						<input type='hidden' name='p_m' value='<?php echo $p_m;?>'/>
						<input type='hidden' name='con_sts' value='<?php echo $con_sts;?>'/>
						<p style="margin-top: 60px;">	
							<label style="font-size: 20px;font-weight: bold;width: 40%;color: red;">Choose Reseller Area: </label>
							<select data-placeholder="Choose Area" name="z_id" class="chzn-select"  style="width:333px;" onchange="submit();">
									<option value=""></option>
									<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
											<option value="<?php echo $row345['z_id']?>"><?php echo $row345['resellername']; ?> - <?php echo $row345['resellerid']; ?> - <?php echo $row345['z_name']; ?></option>
									<?php } ?>
							</select>
						</p>
					</form>	
				<?php } else{ ?>				
					<a style='font-size: 15px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[User Limit Exceeded]</a>
				<?php } ?>	
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