<?php
$titel = "Add Client";
include('include/hader.php');
extract($_POST);

ini_alter('date.timezone','Asia/Almaty');
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(110, $access_arry)){
//---------- Permission -----------
$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11=mysql_query($query11);

$query1t1="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$resulttt11=mysql_query($query1t1);
$r2ff = mysql_fetch_assoc($resulttt11);
$totmk = mysql_num_rows($resulttt11);

if($user_type == 'billing'){
$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name";
}
else{
$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
}
$result=mysql_query($query);
$query1="SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' order by id ASC";
$result1=mysql_query($query1);

$query1zz="SELECT box_id, b_name, location, b_port FROM box ORDER BY box_id ASC";
$result1zz=mysql_query($query1zz);

$query1zzz="SELECT e_id, e_name, e_des FROM emp_info WHERE mk_id = '' ORDER BY e_id ASC";
$result111=mysql_query($query1zzz);

$query1zzzff="SELECT e_id, e_name, e_des FROM emp_info WHERE mk_id = '' ORDER BY e_id ASC";
$result11122=mysql_query($query1zzzff);

$sql2oo ="SELECT last_id FROM app_config";

$query2oo = mysql_query($sql2oo);
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['last_id'];
$com_id = $idzff + 1;

if (isset($_POST["upload"])) {
    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );
    
    // Get image file extension
    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
    
    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "Choose image file to upload."
        );
    }    // Validate file input to check if is with valid extension
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $response = array(
            "type" => "error",
            "message" => "Upload valiid images. Only PNG and JPEG are allowed."
        );
        echo $result;
    }    // Validate image file size
    else if (($_FILES["file-input"]["size"] > 2000000)) {
        $response = array(
            "type" => "error",
            "message" => "Image size exceeds 2MB"
        );
    }    // Validate image file dimension
    else if ($width > "300" || $height > "200") {
        $response = array(
            "type" => "error",
            "message" => "Image dimension should be within 300X200"
        );
    } else {
        $target = "image/" . basename($_FILES["file-input"]["name"]);
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
            $response = array(
                "type" => "success",
                "message" => "Image uploaded successfully."
            );
        } else {
            $response = array(
                "type" => "error",
                "message" => "Problem in uploading image files."
            );
        }
    }
}

	?>
	<div class="box box-primary">
		<div class="span6">
			<div class="accordion accordion-inverse" style="padding: 5px 0px 13px 10px;font-size: 15px;font-weight: bold;border-bottom: 2px solid #bbb;margin-bottom: 18px;">
				<a href="#">Add New Client (PPPoE)</a>
			</div>
		</div>
		<div class="box-header" style="padding: 0px 10px 0px 10px;">
			<form id="form" class="stdform" method="post" action="ClientAddQuery" enctype="multipart/form-data">
			<input type="hidden" name="ppoe_comment" value="<?php echo $ppoe_comment;?>" />
			<input type="hidden" name="u_type" value="client" />
			<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
			<input type="hidden" name="entry_date" value="<?php echo date('Y-m-d', time());?>" />
			<input type="hidden" name="entry_time" value="<?php echo date('H:i:s', time());?>" />
			<input type="hidden" name="com_id" readonly required="" value="<?php echo $com_id;?>"/>
							<p>
								<label class="textname" style="float: left;padding: 5px 60px 0 0;">Company ID*</label>
								<span class="field" style="margin-left: 0px;font-size: 30px;font-weight: bold;color: #cc4612;width: 24%;float: left;text-align: center;"><?php echo $com_id;?></span>
							</p><br>
							<p>	
								<label class="textname">Zone*</label>
									<select data-placeholder="Choose a Zone..." name="z_id" id="z_id" class="chzn-select" style="width:100%;" required="" onChange="getRoutePoint(this.value)">
									<option value=""></option>
										<?php while ($row=mysql_fetch_array($result)) { ?>
									<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
											<?php } ?>
								</select>
							</p>
							<p>	
								<div id="Pointdiv1">
								<label class="textname">Sub-Zone</label>
									<select data-placeholder="Choose a Box" class="chzn-select" style="width:100%;" name="" />
											<option value=""></option>
									</select>
								</div>
							</p>
							<?php if($totmk == '1'){ ?>
								<input type="hidden" name="mk_id" value="<?php echo $r2ff['id'];?>" />
							<?php } if($totmk > '1'){ ?>
							<p>	
								<label class="textname">Network*</label>
								<select data-placeholder="Choose a Network..." id="mk_id" name="mk_id" class="chzn-select" style="width:100%;" required="">
									<option value=""></option>
										<?php while ($row11=mysql_fetch_array($result11)) { ?>
									<option value="<?php echo $row11['id']?>"><?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
										<?php } ?>
								</select>
							</p>
							<?php } if($totmk == '0'){?>
							<p>	
								<label class="textname">Network*</label>
								<a class="btn ownbtn4" href="Network" data-toggle=""> Please Add Mikrotik First</a>
							</p>
							<?php } ?>
							<div id="resultpackage" style="font-weight: bold;">

							</div>
							<?php if($user_type == 'superadmin' || $user_type == 'admin'){ ?>
								<p>
									<label class="textname">Permanent Discount</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="discount" style="width:30%;" placeholder="Ex: 1200" id="" class="input-xxlarge" /></span>
								</p>
								<?php } else{ ?>
								<p>
									<label class="textname">Permanent Discount</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="" style="width:30%;" readonly placeholder="0.00" id="" class="input-xxlarge" /></span>
								</p>
							<?php } ?>
							
							<p>
								<label class="textname">This Month Bill</label>
								<select name="qcalculation" class="chzn-select" style="width:70%;"/>
										<option value="Manual">Manual</option>
										<option value="Auto">Auto</option>
										<option value="No">No Bill</option>
								</select>
							</p>
							<p>
								<label class="textname">Client Name*</label>
								<span class="field" style="margin-left: 0px;"><input type="text" name="c_name" id="" required="" style="width:100%;" class="input-xxlarge" /></span>
							</p>
							<p id="result" style="font-weight: bold;"></p>
							<p>
								<label class="textname">PPPoE ID*</label>
								<input type="text" name="c_id" id="name" placeholder="User id must be at least 3 characters long" style="width:100%;" class="input-xxlarge" required="" />
							</p>
							<p>
								<label class="textname">PPPoE Password*</label>
								<input type="text" name="passid" class="input-xxlarge" size="12" style="width:100%;" required="" />
							</p>
							<p>
								<label class="textname">Cell No*</label>
								<input type="text" name="cell" style="width:100%;" placeholder="Must Use 8801XXXXXXXXX" required="" value = '88' id="" class="input-xxlarge" />
							</p>
							<p>
								<label class="textname">Send Login SMS</label>
								<select name="sentsms" class="chzn-select" style="width:70%;"/>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
								</select>
							</p>
							<p>
								<label class="textname">Payment Deadline</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="payment_deadline" style="width:30%;" placeholder="Date like: 07 or 09" id="" class="input-xxlarge"></span>
							</p>
							<p>
								<label class="textname">Billing Deadline</label>
								<span class="field" style="margin-left: 0px;"><input type="text" name="b_date" style="width:30%;" placeholder="Date like: 07 or 09" id="" class="input-xxlarge"></span>
							</p>
							<p>	
								<label class="textname">Payment Method*</label>
								<select data-placeholder="Payment Method" name="p_m" class="chzn-select" style="width:100%;" required="" >
									<option value="Home Cash">Cash from Home</option>
									<option value="Cash">Cash</option>
									<option value="Office">Office</option>
									<option value="bKash">bKash</option>
									<option value="Rocket">Rocket</option>
									<option value="iPay">iPay</option>
									<option value="Card">Card</option>
									<option value="Bank">Bank</option>
									<option value="Corporate">Corporate</option>
								</select>
							</p>
							<p>
								<label class="textname">Signup Fee</label>
								<span class="field" style="margin-left: 0px;"><input type="text" name="signup_fee" style="width:100%;" placeholder="Ex: 1200" id="" class="input-xxlarge" /></span>
							</p>
							<p>
								<label style="width: 100%;font-size: 10px;">Type of Client</label>
								<span class="field" style="margin-left: 0px;">
									<select class="chzn-select" name="con_type" style="width:100%;" required="" >
										<option value="Home">Home</option>
										<option value="Corporate">Corporate</option>
										<option value="Others">Others</option>
									</select>
								</span>					
							</p>
							<p>
								<label style="width: 100%;font-size: 10px;">Type of Connectivity</label>
								<span class="field" style="margin-left: 0px;">
									<select class="chzn-select" name="connectivity_type" style="width:100%;" required="" >
										<option value="Shared">Shared</option>
											<option value="Dedicated">Dedicated</option>
									</select>
								</span>					
							</p>
							<p>
								<label class="textname">Cable Type</label>
								<span class="field" style="margin-left: 0px;">
									<select class="chzn-select" name="cable_type" style="width:100%;" required="" >
										<option value="UTP">UTP</option>
										<option value="FIBER">FIBER</option>
									</select>
								</span>
							</p>
							<p>
								<label class="textname">Require Cable</label>
								<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="req_cable" placeholder="Ex: 200ft" id="" class="input-xxlarge" /></span>
							</p>
							<p>
								 <label style="width: 100%;font-size: 10px;">Present Address</label>
								<span class="field" style="margin-left: 0px;"><textarea type="text" style="width:100%;" name="address" id="" class="input-xxlarge"/></textarea></span>
							</p>
							<p>
								 <label style="width: 100%;font-size: 10px;">Thana</label>
								<span class="field" style="margin-left: 0px;"><input type="text" style="width:100%;" name="thana" placeholder="" id="" class="input-xxlarge" /></span>
							</p>
							<p>
								<label style="width: 100%;font-weight: bold;font-size: 10px;">Joining Date*</label>
								<span class="field" style="margin-left: 0px;"><input type="text" style="width:100%;" name="join_date" id="" required="" class="input-xxlarge datepicker" value="<?php echo date("Y-m-d");?>"></span>
							</p>
							<p>
								 <label style="width: 100%;font-size: 10px;">National ID</label>
								<span class="field" style="margin-left: 0px;"><input type="text" style="width:100%;" name="nid" placeholder="Ex: 123456789" id="" class="input-xxlarge" /></span>
							</p>
							<p>
								<label style="width: 100%;font-size: 10px;">Note</label>
								<span class="field" style="margin-left: 0px;"><textarea type="text" style="width:100%;" name="note" placeholder="Optional" id="" class="input-xxlarge" /></textarea></span>
							</p>
							<p>
								<label class="control-label" for="com_logo" style="width: 100%;font-size: 10px;">Image</label>
								<div class="controls">
									<span class="btn btn-file">
										<span class="fileupload-new">Choose Image</span>
										<input type="file" class="file-input" name="file-input" onchange="readURL(this);">
									</span>
										<img id="blah" src="<?php echo $weblink;?>/emp_images/no_img.jpg" alt="" style="width: 50px;height: 50px;margin-left: 7px;"/>
								</div>
							</p>
					<div class="modal-footer">
						<button type="reset" class="btn">Reset</button>
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>
			</form>	
 <?php if(!empty($response)) { ?>
    <div class="response <?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
    <?php }?>
		</div>
	</div>

<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#name").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 3)
  {  
   $("#result").html('checking...');
   $.ajax({
    
    type : 'POST',
    url  : 'username-check.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
 
});
</script>
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
		
		var strURL="findzonebox.php?z_id="+afdId;
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
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(50)
                        .height(50);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="mk_id"]').on('change',function(){
           var CatID = jQuery(this).val();
           if(CatID)
			{
				$(document).ready(function()
				{    
				 jQuery('select[name="p_id"]').on('change',function(){
				  var p_id = jQuery(this).val(); 
				   $.ajax({
					type : 'POST',
					url  : "mk-pack-check.php?mk_id="+CatID,
					data : jQuery(this),
					success : function(data)
						{
							  $("#resultpack").html(data);
						   }
					});
					return false;
				 });
				});
			}
        });
});
</script>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="mk_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $("#ip").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 7)
				  {  
				   $("#result1").html("<p><label style='width: 130px'></label><span class='field' style='margin-left: 0px;'>checking...</span></p>");

				   $.ajax({
					
					type : 'POST',
					url  : "ip-mac-check1.php?mk_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#result1").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#result1").html('');
				  }
				 });
				});
			}
        });
});
</script>

<script type="text/javascript">
$(document).ready(function(){  
    $('#z_id').on('change',function(){ 
        var z_id = $('#z_id').val();
        $.ajax({  
				type: 'POST',
                url: "zone_packages.php",
                data:{z_id:z_id},
                success:function(data){
                    $('#resultpackage').html(data);
                }
        });  
    });

	$('#z_id').on('change',function(){ 
        var z_id = $('#z_id').val();
        $.ajax({  
				type: 'POST',
                url: "zone_thana.php?for=add",
                data:{z_id:z_id},
                success:function(data){
                    $('#resultthana').html(data);
                }
        });  
    });  
});
</script>
<style>
#frm-image-upload{
    padding: 0px;
    background-color: lightblue;
}

.textname {
width: 100%;
font-weight: bold;
font-size: 14px;
line-height: 15px;
margin-bottom: 3px;
padding: 0;
text-transform: uppercase;
}

.form-row {
    padding: 20px;
    border-top: #8aacb7 1px solid;
}

.button-row {
    padding: 10px 20px;
    border-top: #8aacb7 1px solid;
}

#btn-submit {
    padding: 10px 40px;
    background: #586e75;
    border: #485c61 1px solid;
    color: #FFF;
    border-radius: 2px;
}

.file-input {
    background: #FFF;
    padding: 5px;
    margin-top: 5px;
    border-radius: 2px;
    border: #8aacb7 1px solid;
}

.response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
}

.error {
    background: #fdcdcd;
    border: #ecc0c1 1px solid;
}

.success {
    background: #c5f3c3;
    border: #bbe6ba 1px solid;
}
</style>