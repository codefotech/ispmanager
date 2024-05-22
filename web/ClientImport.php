<?php
$titel = "Import Own Clients";
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
        <div class="pageicon"><i class="iconfa-download-alt"></i></div>
        <div class="pagetitle">
            <h1>Import Own Clients</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Import Own Clients Data by CSV</h5>
				</div>
					<form class="stdform" action="ClientImportQuery" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
						<input type="hidden" name="bill_date" value="<?php echo date('Y-m-01');?>" />
						<input type="hidden" name="bill_date_time" value="<?php echo date("Y-m-01 H:i:s");?>" />
							<div class="modal-body">
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
										<input type="radio" name="addmk" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
										<input type="radio" name="addmk" value="No"> No &nbsp; &nbsp;
									</span>
								</p>
								<p>
									<label>Zone*</label>
									<select name="z_id" data-placeholder="Choose a Zone" class="chzn-select"  style="width:280px;" required="">
										<option value=""></option>
										<?php 
											$queryd="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_id ASC";
											$resultd=mysql_query($queryd);
										while ($rowd=mysql_fetch_array($resultd)) { ?>			
											<option value=<?php echo $rowd['z_id'];?> <?php if ($rowd['z_id'] == $z_id) echo 'selected="selected"';?> ><?php echo $rowd['z_name'];?> (<?php echo $rowd['z_bn_name'];?>)</option>		
										<?php } ?>
									</select>
								</p>
								<p>
									<label></label>
									<span class="field"><a href="exl/Example_CSV.csv">[Download Example CSV]</a></span>
								</p>
								<p>
									<label>Choose CSV File</label>
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