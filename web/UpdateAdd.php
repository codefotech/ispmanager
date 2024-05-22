<?php
$titel = "Change Update";
$Update = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Update' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
<script type="text/javascript" src="js/wysiwyg.js"></script>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Update"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Update</h1>
        </div>
    </div><!--pageheader-->
	<?php if ($stat == 'done'){?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			 <strong>Successfully!!</strong> Your data successfully Inserted In Your Database.
		</div>
	<?php } ?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Update News</h5>
				</div>
					<form id="form" class="stdform" method="post" action="UpdateAddSave">
						<input type="hidden" name="send_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
							<div class="modal-body">
								<p>	
									<label>Version</label>
									<select data-placeholder="Version..." name="version" class="chzn-select"  style="width:10% !important;" required="">
										<option value=""></option>
										<option value="2.0">v2.0</option>
										<option value="2.1">v2.1</option>
										<option value="2.2">v2.2</option>
										<option value="2.3">v2.3</option>
										<option value="2.4">v2.4</option>
										<option value="2.5">v2.5</option>
										<option value="2.6">v2.6</option>
										<option value="2.7">v2.7</option>
										<option value="2.8">v2.8</option>
										<option value="2.9">v2.9</option>
										<option value="3.0">v3.0</option>
										<option value="3.1">v3.1</option>
										<option value="3.2">v3.2</option>
										<option value="3.3">v3.3</option>
										<option value="3.4">v3.4</option>
										<option value="3.5">v3.5</option>
										<option value="3.6">v3.6</option>
										<option value="3.7">v3.7</option>
										<option value="3.8">v3.8</option>
										<option value="3.9">v3.9</option>
										<option value="5.1">v5.1</option>
										<option value="6.2">v6.2</option>
										<option value="7.4">v7.4</option>
										<option value="7.8">v7.8</option>
										<option value="8.2">v8.2</option>
										<option value="8.6">v8.6</option>
										<option value="8.8" selected>v9.1</option>
									</select>
								</p>
								<p>	
									<label>Subject</label>
									<span class="field"><input type="text" name="update_subject" id="" required="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Description</label>
									<span class="field"><textarea type="text" name="update_desc" placeholder="Optional" id="" class="input-xxlarge" /></textarea></span>
								</p>
								<p>
									<label>Send Invoice SMS</label>
										<span class="formwrapper">
										<input type="radio" name="sentsms" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
										<input type="radio" name="sentsms" value="No"> No &nbsp; &nbsp;
									</span>
								</p>
								<p>	
									<label>Administrator</label>
									<select data-placeholder="Choose a Admin..." name="update_by" class="chzn-select"  style="width:20% !important;" required="">
										<option value="BAPA">BAPA</option>
										<option value="BAPA">BAPA</option>
									</select>
								</p>
								<p>
									<label>Update Date Time</label>
									<span class="field"><input type="text" name="update_time" placeholder="" required="" id="" class="input-xlarge" value="<?php echo date("Y-m-d H:i:s");?>" /></span>

								</p>
								<p>
									<label>Publish Date</label>
									<span class="field"><input type="text" name="publish_time" placeholder="" required="" id="" class="input-xlarge" value="<?php echo date("Y-m-d H:i:s");?>" /></span>
								</p>
								<p>	
									<label>New?</label>
									<select data-placeholder="Choose a Admin..." name="new" class="chzn-select"  style="width:20% !important;" required="">
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</p>
								<p>	
									<label>Publish In Welcome Page?</label>
									<select data-placeholder="Choose a Admin..." name="publish_status" class="chzn-select"  style="width:20% !important;" required="">
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</p>
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