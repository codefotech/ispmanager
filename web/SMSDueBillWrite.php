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

//$query22="SELECT * FROM zone WHERE status = '0' order by z_name";
if($userr_typ == 'mreseller'){
$query22="SELECT box_id, b_name, location FROM box WHERE z_id = '$macz_id' AND sts = '0' order by b_name";
}
else{
$query22="SELECT z_id, z_name, z_bn_name FROM zone WHERE status = '0' AND e_id = '' order by z_name";
}
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
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
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
									<span class="field">
									<?php if($userr_typ == 'mreseller'){ ?>
										<input type="hidden" name="z_id" value="<?php echo $macz_id;?>" />
										<select data-placeholder="Choose a Zone" name="box_id" id="box_id" class="chzn-select"  style="width:240px;">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result22)) { ?>
											<option value="<?php echo $row['box_id']?>"><?php echo $row['b_name']; ?> (<?php echo $row['b_name'];?>)</option>
												<?php } ?>
										</select>
									<?php } else{?>
										<select data-placeholder="Choose a Zone" name="z_id" id="z_id" class="chzn-select"  style="width:240px;">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result22)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name'];?>)</option>
												<?php } ?>
										</select>
										<?php } ?>
									</span>

								</p>
								<p>	
									<label>Payment Method</label>
									<select data-placeholder="Payment Method" name="p_m" id="p_m" class="chzn-select" style="width:333px;" required="">
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
									<label>Partial</label>
										<select class="select-ext-large chzn-select" style="width:240px;" name="partial" id="partial">
											<option value="all"> All Due </option>
											<option value="1">Partial Due</option>
											<option value="2">Not Partial Due</option>
										</select>
								</p>
								<?php if($userr_typ != 'mreseller'){ ?>
								<p>	
									<label>Payment Deadline</label>
									<select name="df_date" id="df_date" class="chzn-select" style="width:165px;" required="">
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
									<select name="dt_date" id="dt_date" class="chzn-select" style="width:165px;" required="">
											<option value="all"> To Any Deadline </option>
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
								<?php } ?>
								<p>
									<label>Status</label>
									<span class="formwrapper">
										<input type="radio" name="con_sts" id="con_sts" value="Active" checked="checked"> Active &nbsp; &nbsp;
										<input type="radio" name="con_sts" id="con_sts" value="Inactive"> Inactive &nbsp; &nbsp;
										<input type="radio" name="con_sts" id="con_sts" value="all"> Both &nbsp; &nbsp;
									</span>
								</p>
								<p>
									<label>Cell No Found</label>
									<span class="formwrapper">
											<a id="resultpack" style="font-weight: bold;font-size: 20px;"></a>
									</span>
								</p>
								<p>
									<label>SMS Text</label>
									<span class="field"><textarea type="text" maxlength="1080" required="" name="sms_body" placeholder="Max 1080" id="" onkeyup="countChar(this)" class="input-xxlarge" /></textarea></span>
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
<?php if($userr_typ == 'mreseller'){ ?>
<script type="text/javascript">
jQuery(document).ready(function(){  
    $("#resultpack").load("client-sms-cellno-count.php?way=mresellerduebillwrite&z_id=<?php echo $macz_id;?>&p_m=all&con_sts=Active&box_id=all&partial=all");
    jQuery('#box_id, #p_m, #con_sts, #dt_date, #df_date, #partial').on('change',function(){ 
        var box_id = jQuery('#box_id').val();
        var p_m = jQuery('#p_m').val();
        var dt_date = jQuery('#dt_date').val();
        var df_date = jQuery('#df_date').val();
        var partial = jQuery('#partial').val();
		var con_sts = jQuery('input[name=con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=mresellerduebillwrite&z_id=<?php echo $macz_id;?>",
                data:{box_id:box_id,p_m:p_m,con_sts:con_sts,dt_date:dt_date,df_date:df_date,partial:partial},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
        });  
    });  
});
</script>
<?php } else{ ?>
<script type="text/javascript">
jQuery(document).ready(function(){  
    $("#resultpack").load("client-sms-cellno-count.php?way=duebillwrite&z_id=all&p_m=all&dt_date=all&df_date=all&con_sts=Active&partial=all");
    jQuery('#z_id, #p_m, #con_sts, #dt_date, #df_date, #partial').on('change',function(){ 
        var z_id = jQuery('#z_id').val();
        var p_m = jQuery('#p_m').val();
        var dt_date = jQuery('#dt_date').val();
        var df_date = jQuery('#df_date').val();
        var partial = jQuery('#partial').val();
		var con_sts = jQuery('input[name=con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=duebillwrite",
                data:{z_id:z_id,p_m:p_m,con_sts:con_sts,dt_date:dt_date,df_date:df_date,partial:partial},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
        });  
    });  
});
</script>
<?php } ?>