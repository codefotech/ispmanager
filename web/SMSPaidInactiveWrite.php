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

$query22="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
$result22=mysql_query($query22);

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
            <h1>SMS To All Due Clients</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Write Due Bill SMS</h5>
				</div>
					<form id="form" class="stdform" method="post" action="SMSDueBillWriteQuery">
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
						<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="send_by" />
							<div class="modal-body">
								<p>
									<label>Zone*</label>
									<span class="field"><select data-placeholder="Choose a Zone..." name="z_id" class="chzn-select" style="width:240px;">
										<option value="all">All Zone</option>
											<?php while ($row22=mysql_fetch_array($result22)) { ?>
										<option value="<?php echo $row22['z_id']?>"><?php echo $row22['z_name']; ?></option>
											<?php } ?>
										</select>
									</span>

								</p>
								<p>	
									<label>Payment Method</label>
									<select data-placeholder="Payment Method" name="p_m" class="chzn-select" style="width:333px;" required="">
											<option value="all">All Payment Method</option>
											<option value="Home Cash">Cash from Home</option>
											<option value="Cash">Cash</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
									</select>
								</p>
								<p>	
									<label>Payment Deadline</label>
									<select name="dt_date" class="chzn-select" style="width:165px;" required="">
											<option value="all"> From Any Deadline </option>
											<option value="01"> 1st<?php echo date(' M Y', time());?></option>
											<option value="02"> 2nd<?php echo date(' M Y', time());?></option>
											<option value="03"> 3rd<?php echo date(' M Y', time());?></option>
											<option value="04"> 4th<?php echo date(' M Y', time());?></option>
											<option value="05"> 5th<?php echo date(' M Y', time());?></option>
											<option value="06"> 6th<?php echo date(' M Y', time());?></option>
											<option value="07"> 7th<?php echo date(' M Y', time());?></option>
											<option value="08"> 8th<?php echo date(' M Y', time());?></option>
											<option value="09"> 9th<?php echo date(' M Y', time());?></option>
											<option value="10"> 10th<?php echo date(' M Y', time());?></option>
											<option value="11"> 11th<?php echo date(' M Y', time());?></option>
											<option value="12"> 12th<?php echo date(' M Y', time());?></option>
											<option value="13"> 13th<?php echo date(' M Y', time());?></option>
											<option value="14"> 14th<?php echo date(' M Y', time());?></option>
											<option value="15"> 15th<?php echo date(' M Y', time());?></option>
											<option value="16"> 16th<?php echo date(' M Y', time());?></option>
											<option value="17"> 17th<?php echo date(' M Y', time());?></option>
											<option value="18"> 18th<?php echo date(' M Y', time());?></option>
											<option value="19"> 19th<?php echo date(' M Y', time());?></option>
											<option value="20"> 20th<?php echo date(' M Y', time());?></option>
											<option value="21"> 21th<?php echo date(' M Y', time());?></option>
											<option value="22"> 22th<?php echo date(' M Y', time());?></option>
											<option value="23"> 23th<?php echo date(' M Y', time());?></option>
											<option value="24"> 24th<?php echo date(' M Y', time());?></option>
											<option value="25"> 25th<?php echo date(' M Y', time());?></option>
											<option value="26"> 26th<?php echo date(' M Y', time());?></option>
											<option value="27"> 27th<?php echo date(' M Y', time());?></option>
											<option value="28"> 28th<?php echo date(' M Y', time());?></option>
											<option value="29"> 29th<?php echo date(' M Y', time());?></option>
											<option value="30"> 30th<?php echo date(' M Y', time());?></option>
											<option value="31"> 31th<?php echo date(' M Y', time());?></option>
									</select>
									<select name="df_date" class="chzn-select" style="width:165px;" required="">
											<option value="all"> From Any Deadline </option>
											<option value="01"> 1st<?php echo date(' M Y', time());?></option>
											<option value="02"> 2nd<?php echo date(' M Y', time());?></option>
											<option value="03"> 3rd<?php echo date(' M Y', time());?></option>
											<option value="04"> 4th<?php echo date(' M Y', time());?></option>
											<option value="05"> 5th<?php echo date(' M Y', time());?></option>
											<option value="06"> 6th<?php echo date(' M Y', time());?></option>
											<option value="07"> 7th<?php echo date(' M Y', time());?></option>
											<option value="08"> 8th<?php echo date(' M Y', time());?></option>
											<option value="09"> 9th<?php echo date(' M Y', time());?></option>
											<option value="10"> 10th<?php echo date(' M Y', time());?></option>
											<option value="11"> 11th<?php echo date(' M Y', time());?></option>
											<option value="12"> 12th<?php echo date(' M Y', time());?></option>
											<option value="13"> 13th<?php echo date(' M Y', time());?></option>
											<option value="14"> 14th<?php echo date(' M Y', time());?></option>
											<option value="15"> 15th<?php echo date(' M Y', time());?></option>
											<option value="16"> 16th<?php echo date(' M Y', time());?></option>
											<option value="17"> 17th<?php echo date(' M Y', time());?></option>
											<option value="18"> 18th<?php echo date(' M Y', time());?></option>
											<option value="19"> 19th<?php echo date(' M Y', time());?></option>
											<option value="20"> 20th<?php echo date(' M Y', time());?></option>
											<option value="21"> 21th<?php echo date(' M Y', time());?></option>
											<option value="22"> 22th<?php echo date(' M Y', time());?></option>
											<option value="23"> 23th<?php echo date(' M Y', time());?></option>
											<option value="24"> 24th<?php echo date(' M Y', time());?></option>
											<option value="25"> 25th<?php echo date(' M Y', time());?></option>
											<option value="26"> 26th<?php echo date(' M Y', time());?></option>
											<option value="27"> 27th<?php echo date(' M Y', time());?></option>
											<option value="28"> 28th<?php echo date(' M Y', time());?></option>
											<option value="29"> 29th<?php echo date(' M Y', time());?></option>
											<option value="30"> 30th<?php echo date(' M Y', time());?></option>
											<option value="31"> 31th<?php echo date(' M Y', time());?></option>
									</select>
								</p>
								<p>
									<label>Status</label>
										<span class="formwrapper">
										<input type="radio" name="con_sts" value="Active" checked="checked"> Active &nbsp; &nbsp;
										<input type="radio" name="con_sts" value="Inactive"> Inactive &nbsp; &nbsp;
										<input type="radio" name="con_sts" value="all"> Both &nbsp; &nbsp;
									</span>
								</p>
								<p>
									<label>SMS Text</label>
									<span class="field"><textarea type="text" maxlength="1080" required="" name="sms_body" placeholder="Max 1080" id="" onkeyup="countChar(this)" class="input-xxlarge" /></textarea></span>
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