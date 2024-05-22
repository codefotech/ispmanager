<?php
$titel = "SMS";
$SMS = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SMS' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

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
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-comment"></i></div>
        <div class="pagetitle">
            <h1>SMS</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add New SMS</h5>
				</div>
					<form id="form" class="stdform" method="post" action="SMSAddSave">
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
						<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="send_by" />
							<div class="modal-body">
								<p>
									<label>Phone No*</label>
									<span class="field"><input type="text" name="cell" id="" required="" class="input-xxlarge" value="88" /></span>

								</p>
								<p>
									<label>SMS Text</label>
									<span class="field"><textarea type="text" maxlength="1080" required="" name="sms_write" placeholder="Max 1080" id="" onkeyup="countChar(this)" class="input-xxlarge" /></textarea></span>
								</p>
								<span class="field"><div id="charNum"></div></span>
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