<?php
$titel = "MacReseller";
$MacReseller = 'active';
include('include/hader.php');
include("conn/connection.php") ;

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'MacReseller' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11=mysql_query($query11);

$sql2 ="SELECT z_id FROM zone ORDER BY z_id DESC LIMIT 1";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$idz = $row2['z_id'];
$z_id = $idz + 1;

$sql22 ="SELECT e_id FROM emp_info ORDER BY e_id DESC LIMIT 1";
$query22 = mysql_query($sql22);
$row22 = mysql_fetch_assoc($query22);
$idz2 = $row22['e_id'];
$mr_id = $idz2 + 1;

if($company_division_id != '0'){
	$sqlss1 = mysql_query("SELECT id AS dis_id, name AS dis_name, bn_name AS dis_bn_name, lat, lon, url FROM `districts` WHERE `division_id` = '$company_division_id'");  
	
	if($company_district_id != '0'){
		$sqlss2 = mysql_query("SELECT id AS upz_id, name AS upz_name, bn_name AS upz_bn_name, url FROM `upazilas` WHERE `district_id` = '$company_district_id'");
	}
}

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Add Mac Reseller</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>New Mac Reseller</h5>
				</div>			
				<form class="stdform" method="post" action="MacResellerAddQuery" name="form" enctype="multipart/form-data">
				<input id="" type="hidden" name="zz_id" value="<?php echo $z_id;?>">
				<input type="hidden" name="e_des" id="" value="Owner"/>
					<div class="modal-body">
						<p>
							<label style="font-weight: bold;">Reseller Name* </label>
							<span class="field">
								<input type="text" name="e_name" id="" class="input-large" required="" placeholder="Reseller Full Name" />
							</span>
						</p>
						<p>
							<label style="font-weight: bold;color: red;">Login Username*</label>
							<span class="field">
								<input type="text" name="c_id" id="name" placeholder="Minimum 5 Characters Long" class="input-large" required="" /><div id="result" style="margin-left: 70px;font-weight: bold;"></div>
							</span>
						</p>
						<p>
							<label class="control-label" style="font-weight: bold;color: red;" for="passid">Login Password*</label>
							<span class="field">
								<input type="password" name="passid" class="input-large" size="12" required="" />
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Contact No* </label>
							<span class="field">
								<input type="text" name="e_cont_per" placeholder="Personal Contact No" required="" class="input-large"/>
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">MAC Area/Zone* </label>
							<span class="field">
								<input type="text" name="z_name" id="" class="input-large" required="" placeholder="Area Name in English" />
								<input type="text" name="z_bn_name" id="" class="input-large" placeholder="Area Name in Bangla" />
							</span>
						</p>
						<p>
							<label>Thana</label>
							<span class="formwrapper" style="margin-left: 0;">
								<?php if($company_division_id == '0' && $company_district_id == '0' || $company_division_id != '0' && $company_district_id == '0'){ ?>
								<a style="font-size: 15px;color: red;font-weight: bold;vertical-align: middle;">[Please Setup Your Division & District First]</a><br>
								<a href="AppSettings?wayyy=Basic Informations" style="font-size: 15px;font-weight: bold;vertical-align: middle;">Go to Settings >> Basic.</a><br>
							<?php } else{ ?>
							<select data-placeholder="Multiple Thana" name="thana[]" class="chzn-select" style="width:445px;" multiple="multiple" tabindex="4">
								<?php 	while ($rdowdst2=mysql_fetch_array($sqlss2)) { ?>
								<option value="<?php echo $rdowdst2['upz_name']?>"> <?php echo $rdowdst2['upz_name'];?> (<?php echo $rdowdst2['upz_bn_name']; ?>)</option>
								<?php } ?>
							</select>
							<?php } ?>
							</span>
						</p>
						<h4 class="h44">Packages & Billing Information </h4>
						<p>
							<label style="font-weight: bold;">Network*</label>
							<select data-placeholder="Choose a Network..." name="mk_id" class="chzn-select" style="width:340px;" required="" onChange="getRoutePoint112(this.value)">
								<option value=""></option>
									<?php while ($row11=mysql_fetch_array($result11)) { ?>
								<option value="<?php echo $row11['id']?>"><?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
									<?php } ?>
							</select>
						</p>
						<div id="Pointdiv201"></div>
						
						<p>
							<label style="font-weight: bold;">Billing Type*</label>
							<span class="formwrapper" style="margin-left: 0;">
								<input type="radio" name="billing_type" value="Postpaid"> Postpaid &nbsp; &nbsp;
								<input type="radio" name="billing_type" value="Prepaid" checked="checked"> Prepaid &nbsp; &nbsp;
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Over Due Amount*</label>
							<span class="field">
								<input type="text" name="over_due" value="0" style="width:80px;text-align: center;height: 25px;font-size: 20px;font-weight: bold;color: brown;"/><input type="text" name="" id="" style="width:17px;height: 25px; color:brown; font-weight: bold;font-size: 20px;border-left: none;" value="৳" readonly="">
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Minimum Recharge Day* </label>
							<span class="field">
								<div class="input-prepend">
								<select data-placeholder="Single Day" name="minimum_day" class="chzn-select" style="width:220px;" required="">
									<option value=""></option> 
									<option value="1">1</option> 
									<option value="2">2</option> 
									<option value="3">3</option> 
									<option value="4">4</option> 
									<option value="5">5</option> 
									<option value="6">6</option> 
									<option value="7">7</option> 
									<option value="8">8</option> 
									<option value="9">9</option> 
									<option value="10">10</option> 
									<option value="11">11</option> 
									<option value="12">12</option> 
									<option value="13">13</option> 
									<option value="14">14</option> 
									<option value="15">15</option> 
									<option value="16">16</option> 
									<option value="17">17</option> 
									<option value="18">18</option> 
									<option value="19">19</option> 
									<option value="20">20</option> 
									<option value="21">21</option> 
									<option value="22">22</option> 
									<option value="23">23</option> 
									<option value="24">24</option> 
									<option value="25">25</option> 
									<option value="26">26</option> 
									<option value="27">27</option> 
									<option value="28">28</option> 
									<option value="29">29</option> 
									<option value="30">30</option> 
								</select>
									<span class="add-on" style="border-radius: 0 5px 5px 0;font-weight: bold;font-size: 13px;border-left: 0px solid transparent;height: 24px;">
										<input type="radio" name="minimum_sts" id="prependedInput" class="span2" value="1" checked="checked"/>&nbsp; Active &nbsp;
									</span>
								</div>
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Minimum Recharge Days* </label>
							<span class="field">
							<div class="input-prepend">
								<select data-placeholder="Multi Days" name="minimum_days[]" class="chzn-select" multiple="multiple" style="width:220px;" tabindex="4">
									<option value=""></option> 
									<option value="1">1</option> 
									<option value="2">2</option> 
									<option value="3">3</option> 
									<option value="4">4</option> 
									<option value="5">5</option> 
									<option value="6">6</option> 
									<option value="7">7</option> 
									<option value="8">8</option> 
									<option value="9">9</option> 
									<option value="10">10</option> 
									<option value="11">11</option> 
									<option value="12">12</option> 
									<option value="13">13</option> 
									<option value="14">14</option> 
									<option value="15">15</option> 
									<option value="16">16</option> 
									<option value="17">17</option> 
									<option value="18">18</option> 
									<option value="19">19</option> 
									<option value="20">20</option> 
									<option value="21">21</option> 
									<option value="22">22</option> 
									<option value="23">23</option> 
									<option value="24">24</option> 
									<option value="25">25</option> 
									<option value="26">26</option> 
									<option value="27">27</option> 
									<option value="28">28</option> 
									<option value="29">29</option> 
									<option value="30">30</option> 
								</select>
								<span class="add-on" style="border-radius: 0 5px 5px 0;font-weight: bold;font-size: 13px;height: 23px;border-left: 0px solid transparent;"><input type="radio" name="minimum_sts" id="prependedInput" class="span2" value="2" />&nbsp; Active &nbsp; </span>
                            </div>
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Auto Recharge?* </label>
							<span class="formwrapper" style="margin-left: 0;">
								<input type="radio" name="auto_recharge" value="1"> Yes &nbsp; &nbsp;
								<input type="radio" name="auto_recharge" value="0" checked="checked"> No &nbsp; &nbsp;
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Serial Start From* </label>
							<span class="field">
								<input type="text" name="last_id" id="" value="0" style="width:75px;text-align: center;font-size: 18px;font-weight: bold;padding: 4px 4px 4px 0;" required="" />
							</span>
						</p>
						<p>
							<label>Prefix </label>
							<span class="field">
								<input type="text" name="prefix" id="" class="input-large" style="width: 10%;" placeholder="like: ABCD" />
							</span>
						</p>
						<p>
						<label>Agent</label>
							<select name="agent_id" class="chzn-select" style="width:240px;" onChange="getRoutePoint11(this.value)">	
								<option value="0">--None--</option>		
							<?php 
								$queryddd="SELECT * FROM agent WHERE sts = '0' order by e_name ASC";
								$resultdww=mysql_query($queryddd);
								while ($rowdrr=mysql_fetch_array($resultdww)) { ?>
								<option value=<?php echo $rowdrr['e_id'];?>><?php echo $rowdrr['e_name'];?> (<?php echo $rowdrr['com_percent'];?>%)</option>		
							<?php } ?>
							</select>
						</p>
						<div id="Pointdiv100"></div>
						<h4 class="h44">Others Information </h4>
						<p>
							<label>Father's Name </label>
							<span class="field">
								<input type="text" name="e_f_name" id="" style="width: 150px;" placeholder="Father's Name" /><input type="text" name="e_m_name" style="margin-left: 2px;width: 150px;" class="input-large" placeholder="Mother's Name" />
							</span>
						</p>
						
						<p>
							<label>Present Address</label>
							<span class="field">
								<textarea type="text" name="pre_address" id="" style="width: 312px;"></textarea>
							</span>
						</p>
						<p>
							<label>Permanent Address</label>
							<span class="field">
								<textarea type="text" name="per_address" id="" style="width: 312px;"></textarea>
							</span>
						</p>
						<p>
							<label>Others Contact No </label>
							<span class="field">
								<input type="text" name="e_cont_office" placeholder="Office Contact No" id="" style="width:150px;"/><input type="text" name="e_cont_family" placeholder="Family Contact No" id="" style="width:150px;margin-left: 2px;"/>
							</span>
						</p>
						<p>
							<label>WhatsApp</label>
							<span class="field">
								<input type="text" name="whatsapp" placeholder="WhatsApp No" style="width:150px;"/><input type="text" name="skype" placeholder="Skype ID" style="width:150px;margin-left: 2px;"/>
							</span>
						</p>
						<p>
							<label>Email </label>
							<span class="field">
								<input type="text" name="email" id="" style="width:230px;" placeholder="abcd@example.com"/>
							</span>
						</p>
						<p>
							<label>National ID</label>
							<span class="field">
							<input type="text" name="n_id" id="" style="width:230px;" placeholder=""/>
							</span>
						</p>
						<p>
							<label>Gender </label>
							<span class="field">
								<input type="radio" id="male" value="Male" checked="checked" name="e_gender"/>
								Male &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; 
								<input type="radio" id="female" value="Female" name="e_gender"/>
								Female 
							</span>
						</p>
						<p>
							<label>
							Marital Status </label>
							<span class="field">
							<input type="radio" id="Unmarried" value="Unmarried" name="married_stu"/>
							Unmarried &nbsp; &nbsp; &nbsp; &nbsp; <input type="radio" id="Married" value="Married" checked="checked" name="married_stu"/>
							Married </span>
						</p>
						<p>
							<label>Blood Group </label>
							<span class="field">
								<select style="width:150px;" class="chzn-select" name="bgroup"/>
									<option value="">Blood Group</option>
									<option value="AB+">AB+</option>
									<option value="AB-">AB-</option>
									<option value="A+">A+</option>
									<option value="A-">A-</option>
									<option value="B+">B+</option>
									<option value="B-">B-</option>
									<option value="O+">O+</option>
									<option value="O-">O-</option>
								</select> 
							</span>
						</p>
						<p>
							<label>Date of Birth </label>
							<span class="field">
								<input type="text" name="e_b_date" id="" style="width:100px;" class="datepicker" readonly placeholder="YYYY-MM-DD"/>
							</span>
						</p>
						<p>
							<label>Joining Date </label>
							<span class="field">
							<input type="text" name="e_j_date" id="" style="width:100px;" class="datepicker" readonly value="<?php echo date("Y-m-d");?>">
							</span>
						</p>
						
						<p>
							<label>Note</label>
							<span class="field">
								<textarea type="text" name="note" id="" placeholder="If any" style="width: 312px;"></textarea>
							</span>
						</p>
						
						<p>
                            <label>Set Default Logo</label>
                            <span class="field">
								<input type='checkbox' name='default_logo' value='0' /> <img src="<?php echo 'images/logo.png';?>" height="25" width="125" alt="" />
							</span>
                        </p>
						<p>
                            <span class="field" style="font-weight: bold;font-size: 16px;color: #317eac;">&nbsp; &nbsp;Or&nbsp; &nbsp;</span>
                        </p>
						<p>
							<label class="control-label"  for="com_logo">Set New Logo</label>
							<div class="controls">
								<span class="btn btn-file">
									<span class="fileupload-new">Choose Logo</span>
									<input type='file' name="reseller_logo" onchange="readURL1(this);" />
								</span>
								<img id="blah1" src="images/logo.png" height="25" width="125" alt="" />
							</div>
						</p>
						<p>
							<span class="field">
								<a style="color: red;font-weight: bold;">[Logo size must be 175X40]</a>
							</span>
						</p>
					</div>
					<!--#wiz1step3-->
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
<script type="text/javascript">
$(document).ready(function()
{    
 $("#name").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 3)
  {  
   $("#result").html('checking...');
   
   /*$.post("username-check.php", $("#reg-form").serialize())
    .done(function(data){
    $("#result").html(data);
   });*/
   
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

     function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah1')
                        .attr('src', e.target.result)
                        .width(125)
                        .height(25);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

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
	

	function getRoutePoint11(afdId) {		
		
		var strURL="agent_commission.php?agent_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv100').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint112(CatID) {		
		
		var strURL="mk-resellr-pack-check.php?mk_id="+CatID;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv201').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
		function getRoutePoint1(afdId) {		
		
		var strURL="mk-reseller-packagename1.php?mk_profile="+afdId;
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
			function getRoutePoint2(afdId) {		
		
		var strURL="mk-reseller-packagename2.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv2').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
			function getRoutePoint3(afdId) {		
		
		var strURL="mk-reseller-packagename3.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv3').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
			function getRoutePoint4(afdId) {		
		
		var strURL="mk-reseller-packagename4.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv4').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
			function getRoutePoint5(afdId) {		
		
		var strURL="mk-reseller-packagename5.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv5').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
				function getRoutePoint6(afdId) {		
		
		var strURL="mk-reseller-packagename6.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv6').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
				function getRoutePoint7(afdId) {		
		
		var strURL="mk-reseller-packagename7.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv7').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
				function getRoutePoint8(afdId) {		
		
		var strURL="mk-reseller-packagename8.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv8').innerHTML=req.responseText;						
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