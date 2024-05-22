<?php
$titel = "Add Queue Clients";
$Clients = 'active';
include('include/hader.php');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql88tt = ("SELECT username FROM sms_setup WHERE status = '0' AND z_id = ''");
		
$querytt = mysql_query($sql88tt);
$rowtt = mysql_fetch_assoc($querytt);
$username= $rowtt['username'];

$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11=mysql_query($query11);

if($user_type == 'billing'){
$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name";
}
else{
$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
}
$result=mysql_query($query);

$query1="SELECT p_id, p_name, p_price, bandwith FROM package order by id ASC";
$result1=mysql_query($query1);

$query1zz="SELECT box_id, b_name, location, b_port FROM box ORDER BY box_id ASC";
$result1zz=mysql_query($query1zz);

$sql2oo ="SELECT com_id FROM clients ORDER BY com_id DESC LIMIT 1";
$query2oo = mysql_query($sql2oo);
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['com_id'];
$com_id = $idzff + 1;
?>

<script type="text/javascript">
function updatesum() {
document.form.total_bandwidth.value = (document.form.raw_download.value -0) + (document.form.raw_upload.value -0) + (document.form.youtube_bandwidth.value -0);
document.form.bill_amount.value = (document.form.bandwidth_price.value -0) + (document.form.youtube_price.value -0);
}
</script>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal21" style="left: 35%;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div id="map" style="width:170%;height:500px;"></div>
		</div>
	</div>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Add Queue Client</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add New Queue Client</h5>
				</div>
				<?php if($limit_accs == 'Yes'){ ?>
					<form id="form" class="stdform" method="post" name="form" action="ClientAddQuery" enctype="multipart/form-data">
						<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date('Y-m-d', time());?>" />
						<input type="hidden" name="entry_time" value="<?php echo date('H:i:s', time());?>" />
						<input type="hidden" name="breseller" value="1" />
							<div class="modal-body">
								<p>
									<label>Company ID</label>
									<span class="field"><input type="text" name="com_id" id="" readonly required="" style="width:140px;" class="input-xxlarge" value="<?php echo $com_id;?>"/></span>
								</p>
								<p>	
									<label style="font-weight: bold;">Zone*</label>
									<select data-placeholder="Choose a Zone..." name="z_id" class="chzn-select" style="width:540px;" required="" onChange="getRoutePoint33(this.value)">
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>	
									<label>Box</label>
									<div id="Pointdiv1">
										<select data-placeholder="Choose a Box" class="chzn-select" style="width:250px;" name="" >
											<option value=""></option>
										</select>
									</div>
								</p>
								<p>	
								<label style="font-weight: bold;">Network*</label>
									<select data-placeholder="Choose a Network..." name="mk_id" class="chzn-select" style="width:540px;" required="">
										<option value=""></option>
											<?php while ($row11=mysql_fetch_array($result11)) { ?>
										<option value="<?php echo $row11['id']?>"><?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>
									<label style="font-weight: bold;">Client Name*</label>
									<span class="field"><input type="text" name="c_name" id="" required="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label style="font-weight: bold;">Client ID*</label>
									<input type="text" name="c_id" id="name" placeholder="User id must be at least 3 characters long" class="input-xxlarge" required="" /><br><span id="result" style="margin-left: 220px; font-weight: bold;"></span>
								</p>
								<p>
									<label class="control-label" for="passid" style="font-weight: bold;">Login Password*</label>
									<div class="controls"><input type="password" name="passid" class="input-xxlarge" size="12" required="" /></div>
								</p>
								<p>
									<label>Father's Name</label>
									<span class="field"><input type="text" name="father_name" id="" class="input-xxlarge" /></span>
									
								</p>
								<a id="result1" style="font-weight: bold;"></a>
								<p>
									<label style="font-weight: bold;">IP Address*</label>
									<span class="field"><input type="text" style="width:240px;" id="ip" name="ip" placeholder="Ex: 192.168.XX.XX" class="input-xlarge"/></span>
								</p>
								<p>
									<label>MAC Address</label>
									<span class="field"><input type="text" style="width:240px;" name="mac" placeholder="" id="" class="input-xlarge" /></span>
								</p>
								<p>
									<label style="font-weight: bold;">Bandwidth*</label>
									<span class="field"><input type="text" name="raw_download" style="width: 135px;" placeholder="Download" required="" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="raw_upload" style="width: 135px;" required="" placeholder="Upload" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="youtube_bandwidth" style="width: 135px;" required="" placeholder="YouTube Bandwidth" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="total_bandwidth" readonly placeholder="Total" style="width: 60px;" onChange="updatesum()" /> <b>mb</b></span>
								</p>
								<p>
									<label style="font-weight: bold;">Price*</label>
									<span class="field"><input type="text" required="" name="bandwidth_price" placeholder="Raw Price" id="" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="youtube_price" required="" placeholder="YouTube Price" id="" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="bill_amount" readonly placeholder="Total" id="" style="width: 60px;" onChange="updatesum()" /> <b>TK</b></span>
								</p>
								<p>
									<label>This Month Bill Calculation</label>
										<span class="formwrapper">
										<input type="radio" name="calculation" value="Auto"> Auto &nbsp; &nbsp;
										<input type="radio" name="calculation" value="Manual" checked="checked"> Manual &nbsp; &nbsp;
									</span>
								</p>
								<p>
									<label>Payment Deadline</label>
									<span class="field"><input type="text" name="payment_deadline" placeholder="Date in every month like: 7" id="" class="input-xlarge"></span>
								</p>
								<p>
									<label>Billing Date</label>
									<span class="field">
										<select data-placeholder="Choose Bill Date" name="b_date" class="chzn-select" style="width:540px;"/>
											<option value="">Choose Bill Date</option>
											<option value="01">01</option>
											<option value="10">10</option>
											<option value="20">20</option>
										</select>
									</span>
								</p>
								<p>
									<label style="font-weight: bold;">Payment Method*</label>
									<span class="field">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:540px;" required="" >
											<option value="Cash">Cash</option>
											<option value="Home Cash">Cash from Home</option>
											<option value="Officeh">Office</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
										</select>
									</span>
								</p>
								<p>
									<label>Signup Fee</label>
									<span class="field"><input type="text" name="signup_fee" placeholder="Ex: 1200" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label style="font-weight: bold;">Cell No*</label>
									<span class="field"><input type="text" name="cell" placeholder="Must Use 8801XXXXXXXXX" required="" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Send Login SMS</label>
									<?php if($username == ''){ ?>
									<span class="field" style="margin-left: 0px;font-weight: bold;padding-top: 5px;font-size: 13px;color: red;">[SMS Not Active]</span>
									<input type="hidden" name="sentsms" value="No" />
									<?php } else{ ?>
									<span class="formwrapper">
										<input type="radio" name="sentsms" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
										<input type="radio" name="sentsms" value="No"> No &nbsp; &nbsp;
									</span>
									<?php } ?>
								</p>
								<p>
									<label>Alternative Cell No 1</label>
									<span class="field"><input type="text" name="cell1" placeholder="Alternative Cell No:1" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Alternative Cell No 2</label>
									<span class="field"><input type="text" name="cell2" placeholder="Alternative Cell No:2" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Alternative Cell No 3</label>
									<span class="field"><input type="text" name="cell3" placeholder="Alternative Cell No:3" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Alternative Cell No 4</label>
									<span class="field"><input type="text" name="cell4" placeholder="Alternative Cell No:4" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Present Address</label>
									<span class="field"><textarea type="text" name="address" id="" class="input-xxlarge"/></textarea></span>
								</p>
								<p>
									<label>Permanent Address</label>
									<span class="field"><textarea type="text" name="old_address" id="" class="input-xxlarge"/></textarea></span>
								</p>
								<p>
									<label>Thana</label>
									<span class="field"><input type="text" name="thana" placeholder="" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Joining Date</label>
									<span class="field"><input type="text" name="join_date" readonly id="" class="input-xxlarge" value="<?php echo date("Y-m-d");?>"></span>
								</p>
								<p>
									<label>Occupation</label>
									<span class="field"><input type="text" name="occupation" placeholder="Occupation" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Email</label>
									<span class="field"><input type="text" name="email" id="" placeholder="Ex: abcd@domain.com" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>National ID</label>
									<span class="field"><input type="text" name="nid" placeholder="Ex: 123456789" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Type of Client</label>
										<span class="field">
											<select class="chzn-select" name="con_type" style="width:540px;" required="" >
												<option value="Home">Home</option>
												<option value="Corporate">Corporate</option>
												<option value="Others">Others</option>
											</select>
										</span>					
								</p>
								<p>
									<label>Type of Connectivity</label>
										<span class="field">
											<select class="chzn-select" name="connectivity_type" style="width:540px;" required="" >
												<option value="Shared">Shared</option>
												<option value="Dedicated">Dedicated</option>
											</select>
										</span>					
								</p>
								<p>
									<label>Cable Type</label>
									<span class="field">
										<select class="chzn-select" name="cable_type" style="width:540px;" required="" onChange="getRoutePoint(this.value)">
											<option value="UTP">UTP</option>
											<option value="FIBER">FIBER</option>
										</select>
									</span>
								</p>
								<div id="Pointdiv" style="margin-left: 70px;"></div>
								<p>
									<label>Require Cable</label>
									<span class="field"><input type="text" name="req_cable" placeholder="Ex: 200ft" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Connection Mode</label>
									<span class="field"><input type="text" name="con_sts" readonly id="" class="input-xlarge" value = "Active" /></span>			
								</p>
								<?php if($tree_sts_permission == '0'){?>
											<p>
												 <label></label>
												<span class="field" style="font-weight: bold;"><h3>Location On Google Map</h3></span>
											</p>
											<p>
												<label></label>
												<span class="field">
													<div class="input-append">
														<p id="latitude"><input type="text" id="" name="latitude" placeholder="Google Map Latitude" class="span2"></p>
														<p id="longitude"><input type="text" id="" name="longitude" placeholder="Google Map Longitude" class="span2"></p>
													</div>
												<a data-placement='top' data-rel='tooltip' href='#myModal21' class='btn btn-circle' data-toggle="modal" style="border-radius: 15%;padding: 10px;width: 3%;"><i class='iconfa-map-marker' style="font-size: 35px;"></i></a>
												</span>
											</p>
								<?php } else{ ?><input type="hidden" id="" name="latitude" placeholder="" class=""><input type="hidden" id="" name="longitude" placeholder="" class=""><?php } ?>
								<p>
									<label>Note</label>
									<span class="field"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xxlarge" /></textarea></span>
								</p>
								
								<p>
									<label class="control-label"  for="com_logo">Image</label>
									<div class="controls">
										<span class="btn btn-file">
											<span class="fileupload-new">Choose Image</span>
											<input type="hidden" name="old_image" value="no" />
											<input type='file' name="main_image" onchange="readURL(this);" />
										</span>
											<img id="blah" src="#" alt="" />
									</div>
								</p>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn ownbtn11">Reset</button>
								<button class="btn ownbtn2" type="submit">Submit</button>
							</div>
					</form>		
				<?php } else{ ?>
					<div style='font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;padding: 30px;font-size: 30px;text-align: center;'>[User Limit Exceeded]</div>
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
	
	function getRoutePoint33(afdId) {		
		
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
		
		var strURL="onu_mac.php?cable_type="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv').innerHTML=req.responseText;						
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
				   $("#result1").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "ip-qq-check.php?mk_id="+CatID1,
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

<script>
var latitude = document.getElementById("latitude");
var longitude = document.getElementById("longitude");
var map;
var faisalabad = {lat:<?php echo $copmaly_latitude;?>, lng:<?php echo $copmaly_longitude;?>};

function addYourLocationButton(map, marker) 
{
    var controlDiv = document.createElement('div');

    var firstChild = document.createElement('button');
    firstChild.style.backgroundColor = '#fff';
    firstChild.style.border = 'none';
    firstChild.style.outline = 'none';
    firstChild.style.width = '40px';
    firstChild.style.height = '40px';
    firstChild.style.borderRadius = '8px';
    firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
    firstChild.style.cursor = 'pointer';
    firstChild.style.marginRight = '10px';
    firstChild.style.padding = '0px';
    firstChild.title = 'Your Location';
    controlDiv.appendChild(firstChild);

    var secondChild = document.createElement('div');
    secondChild.style.margin = '11px';
    secondChild.style.width = '18px';
    secondChild.style.height = '18px';
    secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
    secondChild.style.backgroundSize = '180px 18px';
    secondChild.style.backgroundPosition = '0px 0px';
    secondChild.style.backgroundRepeat = 'no-repeat';
    secondChild.id = 'you_location_img';
    firstChild.appendChild(secondChild);

    google.maps.event.addListener(map, 'dragend', function() {
        $('#you_location_img').css('background-position', '0px 0px');
    });

    firstChild.addEventListener('click', function() {
        var imgX = '0';
        var animationInterval = setInterval(function(){
            if(imgX == '-18') imgX = '0';
            else imgX = '-18';
            $('#you_location_img').css('background-position', imgX+'px 0px');
        }, 500);
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				latitude.innerHTML = "<input type='text' class='span2' placeholder='Map Latitude' readonly name='latitude' value='" + position.coords.latitude + "'/>";
				longitude.innerHTML = "<input type='text' class='span2' placeholder='Map longitude' readonly name='longitude' value='" + position.coords.longitude + "'/>";
                marker.setPosition(latlng);
                map.setCenter(latlng);
                clearInterval(animationInterval);
                $('#you_location_img').css('background-position', '-144px 0px');
            });
        }
        else{
            clearInterval(animationInterval);
            $('#you_location_img').css('background-position', '0px 0px');
        }
    });

 google.maps.event.addListener(map, 'click', function(event) {
     marker = new google.maps.Marker({position: event.latLng, map: map});
     console.log(event.latLng);   // Get latlong info as object.
     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
 });
 google.maps.event.addListener(map, 'click', function(event) {
	latitude.innerHTML = "<input type='text' class='span2' placeholder='Map Latitude' readonly name='latitude' value='" + event.latLng.lat() + "'/>";
	longitude.innerHTML = "<input type='text' class='span2' placeholder='Map longitude' readonly name='longitude' value='" + event.latLng.lng() + "'/>";
});

    controlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
}

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: faisalabad
    });
    var myMarker = new google.maps.Marker({
        map: map,
        animation: google.maps.Animation.DROP,
        position: faisalabad
    });
    addYourLocationButton(map, myMarker);
	<?php if($location_service == '1'){?>
function getLocation() {
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
} else { 
latitude.innerHTML = "<input type='text' class='span2' placeholder='Map Latitude' readonly name='latitude' />";
longitude.innerHTML = "<input type='text' class='span2' placeholder='Map longitude' readonly name='longitude' />";
}
}

function showPosition(position) {
latitude.innerHTML = "<input type='text' class='span2' placeholder='Map Latitude' readonly name='latitude' value='" + position.coords.latitude + "'/>";
longitude.innerHTML = "<input type='text' class='span2' placeholder='Map longitude' readonly name='longitude' value='" + position.coords.longitude + "'/>";
}

window.onClick=getLocation();
<?php } ?>
}

$(document).ready(function(e) {
    initMap();
}); 
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&callback=initMap"></script>