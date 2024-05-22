<?php
$titel = "SMS";
$SMS = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$way = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SMS' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($userr_typ == 'mreseller'){
$query1="SELECT id, p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '$macz_id' ORDER BY p_id";
$query="SELECT box_id, b_name, location FROM box WHERE z_id = '$macz_id' AND sts = '0' order by b_name";

}
else{
$query1="SELECT id, p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' ORDER BY p_id";
$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
}
$result1=mysql_query($query1);
$result=mysql_query($query);

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
            <h1>Sent SMS</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
			<?php if ($way == 'Welcome'){ 
			
if($userr_typ == 'mreseller'){
	$sqlsdf = mysql_query("SELECT sms_msg, from_page, variable FROM sms_msg WHERE from_page = 'Add Client' AND z_id = '$macz_id'");
	
	$sqlqqmm = mysql_query("SELECT e_name AS reseller_fullnamee, e_cont_per AS reseller_celll FROM emp_info WHERE z_id = '$macz_id'");
	$row22m = mysql_fetch_assoc($sqlqqmm);
	$reseller_fullnamee = $row22m['reseller_fullnamee'];
	$reseller_celll = $row22m['reseller_celll'];
}
else{
	$sqlsdf = mysql_query("SELECT sms_msg, from_page, variable FROM sms_msg WHERE id= '1'");
}
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];
$variable= $rowsm['variable'];
			
			?>
				<div class="modal-header">
					<h5>Sent Zone Wise Welcome SMS</h5>
				</div>
					<form id="form" class="stdform" method="post" action="SMSMultiAddSave">
						<input type="hidden" name="way" value="<?php echo $way; ?>" />
						<input type="hidden" name="enty_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
						<input type="hidden" value="<?php echo $userr_typ;?>" name="userr_typ" />
							<div class="modal-body" style="min-height: 550px;">
								<p>	
									<label style="font-weight: bold;">Zone*</label>
									<?php if($userr_typ == 'mreseller'){ ?>
										<input type="hidden" name="z_id" id="z_id" value="<?php echo $macz_id;?>" />
										<select data-placeholder="Choose a Zone" name="box_id" id="box_id" class="chzn-select"  style="width:240px;">
												<option value="all"> All Zone </option>
													<?php while ($row=mysql_fetch_array($result)) { ?>
												<option value="<?php echo $row['box_id']?>"><?php echo $row['b_name']; ?> (<?php echo $row['b_name'];?>)</option>
													<?php } ?>
										</select>
									<?php } else{?>
										<select data-placeholder="Choose a Zone..." name="z_id" id="z_id" class="chzn-select" style="width:345px;" required="" onChange="getRoutePoint(this.value)">
											<option value="all">All Zone</option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id'];?>"><?php echo $row['z_name'];?> (<?php echo $row['z_bn_name'];?>)</option>
												<?php } ?>
										</select>
									<?php } ?>
								</p>
								<?php if($userr_typ != 'mreseller'){ ?>
								<div id="Pointdiv1">

								</div>
								<?php } ?>
								<p>	
									<label>Payment Method</label>
									<select data-placeholder="Payment Method" name="p_m" id="p_m" class="chzn-select" style="width:345px;" required="">
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
								<br>
								<p>
									<label>SMS Text</label>
									<span class="field">
										<div class="span7" style="width: 40%;border-right: 1px solid #ddd;">
											<textarea type="text" name="sms_msg" style="width:92%;height: 225px;" required="" id="sms_msg" placeholder="" class="input-large" /><?php echo $sms_msg;?></textarea>
										</div>
										<div class="span3" style="width: 15%;"><?php echo $variable;?></div>										
									</span>
								</p>
								<span class="field"><div id="charNum"></div></span>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn ownbtn11">Reset</button>
								<button class="btn ownbtn2" type="submit">Submit</button>
							</div>
					</form>
				<?php } if ($way == 'ZoneWiseSMS'){ ?>
				<div class="modal-header">
					<h5>Sent Zone Wise SMS to All Clients</h5>
				</div>
					<form id="form" class="stdform" method="post" action="SMSMultiAddSave">
						<input type="hidden" name="way" value="<?php echo $way; ?>" />
						<input type="hidden" name="enty_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
						<input type="hidden" value="<?php echo $userr_typ;?>" name="userr_typ" />
							<div class="modal-body">
								<p>	
									<label style="font-weight: bold;">Zone*</label>
									<?php if($userr_typ == 'mreseller'){ ?>
										<input type="hidden" name="z_id" id="z_id" value="<?php echo $macz_id;?>" />
										<select data-placeholder="Choose a Zone" name="box_id" id="box_id" class="chzn-select"  style="width:240px;">
												<option value="all"> All Zone </option>
													<?php while ($row=mysql_fetch_array($result)) { ?>
												<option value="<?php echo $row['box_id']?>"><?php echo $row['b_name']; ?> (<?php echo $row['b_name'];?>)</option>
													<?php } ?>
										</select>
									<?php } else{?>
										<select data-placeholder="Choose a Zone..." name="z_id" id="z_id" class="chzn-select" style="width:345px;" required="" onChange="getRoutePoint(this.value)">
											<option value="all">All Zone</option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id'];?>"><?php echo $row['z_name'];?> (<?php echo $row['z_bn_name'];?>)</option>
												<?php } ?>
										</select>
									<?php } ?>
								</p>
								<?php if($userr_typ != 'mreseller'){ ?>
								<div id="Pointdiv1">

								</div>
								<?php } ?>
								<p>	
									<label>Payment Method</label>
									<select data-placeholder="Payment Method" name="p_m" id="p_m" class="chzn-select" style="width:345px;" required="">
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
				<?php } if($way == 'PackageWiseSMS'){ ?>
				<div class="modal-header">
					<h5>Sent Package Wise SMS to All Clients</h5>
				</div>
					<form id="form" class="stdform" method="post" action="SMSMultiAddSave">
						<input type="hidden" name="way" value="<?php echo $way; ?>" />
						<input type="hidden" name="enty_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
						<input type="hidden" value="<?php echo $macz_id;?>" name="macz_id" />
						<input type="hidden" value="<?php echo $userr_typ;?>" name="userr_typ" />
							<div class="modal-body">
								<p>	
									<label>Package*</label>
									<?php if($userr_typ == 'mreseller'){ ?><input type="hidden" name="z_id" value="<?php echo $macz_id;?>" /><?php } else{}?>
									<select data-placeholder="Choose a Package..." name="p_id" id="p_id" class="chzn-select" style="width:540px;" required="">
										<option value="all">All Package</option>
											<?php while ($row1=mysql_fetch_array($result1)) { ?>
										<option value="<?php echo $row1['p_id']?>"><?php echo $row1['p_name']; ?> (<?php echo $row1['bandwith']; ?> - <?php echo $row1['p_price'];?>tk)</option>
											<?php } ?>
									</select>
								</p>
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
											<a id="resultpack1" style="font-weight: bold;font-size: 20px;"></a>
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
<?php if($userr_typ == 'mreseller'){ ?>
<script type="text/javascript">
jQuery(document).ready(function(){  
    $("#resultpack").load("client-sms-cellno-count.php?way=mresellerzonemulti&z_id=<?php echo $macz_id;?>&p_m=all&con_sts=Active&box_id=all");
    jQuery('#box_id, #p_m, #con_sts').on('change load',function(){ 
        var box_id = jQuery('#box_id').val();
        var p_m = jQuery('#p_m').val();
		var con_sts = jQuery('input[name=con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=mresellerzonemulti&z_id=<?php echo $macz_id;?>",
                data:{box_id:box_id,p_m:p_m,con_sts:con_sts},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
        });  
    });  
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){  
    $("#resultpack1").load("client-sms-cellno-count.php?way=mresellerpackmulti&p_id=all&con_sts=Active&z_id=<?php echo $macz_id;?>");
    jQuery('#p_id, #con_sts').on('change load',function(){ 
        var p_id = jQuery('#p_id').val();
		var con_sts = jQuery('input[name=con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=mresellerpackmulti&z_id=<?php echo $macz_id;?>",
                data:{p_id:p_id,con_sts:con_sts},
                success:function(data){
                    jQuery('#resultpack1').html(data);
                }
        });  
    });  
});
</script>
<?php } else{ ?>
<script type="text/javascript">
jQuery(document).ready(function(){  
    $("#resultpack").load("client-sms-cellno-count.php?way=zonemulti&z_id=all&box_id=all&p_m=all&con_sts=Active");
    jQuery('#z_id, #box_id, #p_m, #con_sts').on('change load',function(){ 
        var z_id = jQuery('#z_id').val();
        var box_id = jQuery('#box_id').val();
        var p_m = jQuery('#p_m').val();
		var con_sts = jQuery('input[name=con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=zonemulti",
                data:{z_id:z_id,box_id:box_id,p_m:p_m,con_sts:con_sts},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
        });  
    });  
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){  
    $("#resultpack1").load("client-sms-cellno-count.php?way=packmulti&p_id=all&con_sts=Active");
    jQuery('#p_id, #con_sts').on('change load',function(){ 
        var p_id = jQuery('#p_id').val();
		var con_sts = jQuery('input[name=con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=packmulti",
                data:{p_id:p_id,con_sts:con_sts},
                success:function(data){
                    jQuery('#resultpack1').html(data);
                }
        });  
    });  
});
</script>
<?php } ?>

<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	
	function getRoutePoint(afdId) {		
		var strURL="findzonebox3.php?z_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
  <script type="text/javascript">
let currentInput = $('#sms_msg');
$(document).on('focus', 'textarea', function() {
	currentInput = $(this);
})

$( 'button[type=button]' ).on('click', function(){
  let cursorPos = currentInput.prop('selectionStart');
  let v = currentInput.val();
  let textBefore = v.substring(0,  cursorPos );
  let textAfter  = v.substring( cursorPos, v.length );
  currentInput.val( textBefore+ $(this).val() +textAfter );
});
  </script>