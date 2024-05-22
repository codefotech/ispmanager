<?php
$titel = "SMS";
$SMS = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SMS' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql = mysql_query("SELECT sms_msg, from_page FROM sms_msg WHERE id= '1'");
$row = mysql_fetch_assoc($sql);
$sms_msg= $row['sms_msg'];

//$template = "I am {{name}}, and I work for {{company}}. I am {{age}}.";

# Your template tags + replacements
$replacements = array(
	'name' => 'Jeffrey',
	'company' => 'Envato',
	'age' => 27
);

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

// I am Jeffrey, and I work for Envato. I am 27.
//echo bind_to_template($replacements, $sms_body);
?>
<script>
      function countChar(val) {
        var len = val.value.length;
        if (len >= 160) {
          val.value = val.value.substring(0, 160);
        } else {
          $('#charNum').text(160 - len);
        }
      };
    </script>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="SMS"><i class="iconfa-arrow-left"></i> Back</a>
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
						<input type="hidden" name="enty_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
							<div class="modal-body">
								<p>
									<label>Phone No*</label>
									<span class="field"><input type="text" name="cell" id="" required="" class="input-xxlarge" value="88" /></span>

								</p>
								<p>
									<label>SMS Text</label>
									<span class="field"><textarea type="text" maxlength="160" required="" name="sms_body" id="" onkeyup="countChar(this)" class="input-xxlarge" /><?php echo bind_to_template($replacements, $sms_msg);?></textarea></span>
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