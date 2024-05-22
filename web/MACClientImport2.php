<?php
$titel = "Clients Import";
$Clients = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$result=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
$result2=mysql_query("SELECT id, ServerIP, Name FROM mk_con WHERE sts = '0'");

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Clients"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-comment"></i></div>
        <div class="pagetitle">
            <h1>Clients</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Import Mac Reseller Clients Data CSV</h5>
				</div>
					<form class="stdform" action="MACClientImportQuery2" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
						<input type="hidden" name="yesterday_date" value="<?php echo date('Y-m-d',strtotime("-1 days"));?>" />
						<input type="hidden" name="mac_user" value="1" />
						<input type="hidden" name="p_m" value="Home Cash" />
						<input type="hidden" name="con_type" value="Home" />
						<input type="hidden" name="connectivity_type" value="Shared" />
						<input type="hidden" name="cable_type" value="UTP" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
							<div class="modal-body">
								<p>
									<label>Reseller*</label>
									<span class="field">
										<select data-placeholder="Choose Reseller" name="z_id" class="chzn-select"  style="width:280px;" required="">
											<option value=""></option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
													<option value="<?php echo $row['z_id']?>"><?php echo $row['resellername']; ?> (<?php echo $row['z_name']; ?>)</option>
											<?php } ?>
										</select>
									</span>
								</p>
								<p>
									<label>Network*</label>
									<span class="field">
										<select data-placeholder="Choose Network" name="mk_id" class="chzn-select"  style="width:280px;" required="">
											<option value=""></option>
											<?php while ($rowdd=mysql_fetch_array($result2)) { ?>
													<option value="<?php echo $rowdd['id']?>"><?php echo $rowdd['Name']; ?> (<?php echo $rowdd['ServerIP']; ?>)</option>
											<?php } ?>
										</select>
									</span>
								</p>
								<p>
									<label>Add in Mikrotik?</label>
										<span class="formwrapper"  style="margin-left: 0px;">
										<input type="radio" name="addmk" value="Yes"> Yes &nbsp; &nbsp;
										<input type="radio" name="addmk" value="No" checked="checked"> No &nbsp; &nbsp;
									</span>
								</p>
								<p>
									<label>Start Date*</label>
									<span class="field"><input type="text" style="width:15%;" name="startdate" id="" required="" readonly value="<?php echo date("Y-m-01");?>"></span>
								</p>
								<p>
									<label>End Date*</label>
									<span class="field"><input type="text" style="width:15%;" name="enddate" id="" required="" class="datepicker" value="<?php echo date("Y-m-d");?>"></span>
								</p>
								<p>
									<label>Choose CSV File*</label>
									<span class="field"><input type="file" name="file" id="file" accept=".csv"></span>

								</p>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn">Reset</button>
								<button class="btn btn-primary" type="submit" id="submit" name="import">Submit</button>
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