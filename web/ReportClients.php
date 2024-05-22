<?php
$titel = "Reports";
$Reports = 'active';
$ReportClients = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(163, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

if($user_type == 'billing'){
$result=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND FIND_IN_SET('$e_id', emp_id) > 0 order by z_name");
$allll = '';
}else{
$result=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
$allll = '<option value="all"> All Zone </option>';
}

if($userr_typ == 'mreseller'){
	$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith, sts, status FROM package WHERE z_id = '$macz_id' AND status = '0' order by p_name");
	$resultsgsg=mysql_query("SELECT box_id, b_name FROM `box` WHERE `z_id` = $macz_id");
}
else{
	$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith, sts, status FROM package WHERE status = '0' order by p_name");
}
?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Clients</h1>
        </div>
    </div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="span3 profile-left" style="">
				<div class="list-group">
					<?php require('include/Reports_menu.php'); ?>
				</div>
			</div>
			<div class="span9 rightside" style="width: 74% !important; margin-left: 15px !important;">
				<div class="box box-primary" style=" margin: 0px;">
					<div class="box-body" style="min-height: 440px;"><br/>
						<center>
							<h4>Clients List</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="fpdf/ClientsList" target="_blank">
								<input type="hidden" name="user_type" id="" readonly value="<?php echo $user_type; ?>" />
								<input type="hidden" name="e_id" id="" readonly value="<?php echo $e_id; ?>" />
									<?php if($userr_typ == 'mreseller'){?>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="box_id" class="chzn-select"  style="width:345px;" />
											<option value="all"> All Zone </option>
												<?php while ($rowaf=mysql_fetch_array($resultsgsg)) { ?>
											<option value="<?php echo $rowaf['box_id']?>"><?php echo $rowaf['b_name']; ?></option>
												<?php } ?>
										</select>
										<input type="hidden" name="z_id" id="" readonly value="<?php echo $macz_id;?>" />
									</div>
									<?php } else{ ?>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;" onChange="getRoutePoint(this.value)">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
												<?php } ?>
										</select>
									</div>
									<div id="Pointdiv1">
										<input type="hidden" name="box_id" id="" readonly value="all" />
									</div>
										<?php } ?>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Packages" name="p_id" class="chzn-select"  style="width:345px;">
											<option value="all"> All Packages </option>
												<?php while ($row=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row['p_id']?>"><?php echo $row['p_name']; ?> (<?php echo $row['bandwith']; ?>)</option>
												<?php } ?>
										</select>
									</div>
									<div class="inputwrapper animate_cus2">
										<div id="custdiv">
											<select data-placeholder="Choose a Area" name="con_sts" class="chzn-select"  style="width:345px;">
												<option value="all"> All Clients </option>
												<option value="active">Active Clients</option>
												<option value="inactive">Inactive Clients</option>
											</select>
										</div>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Payment Method" name="p_m" class="chzn-select" style="width:345px;">
											<option value="all">All Payment Method</option>
											<option value="Cash">Cash</option>
											<option value="Home Cash">Cash from Home</option>
											<option value="Office">Office</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
										</select>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Packages" name="df_date" class="chzn-select"  style="width:145px;">
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
										<select data-placeholder="Choose a Packages" name="dt_date" class="chzn-select"  style="width:145px;">
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
									</div>
									
									<!---<div class="inputwrapper1 animate_cus2">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" placeholder="From Date"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" placeholder="To Date"/>
										</div>
									</div>--->
									<div class="">
										<button class="btn ownbtn2" type="submit" style="width: 250px;">Download PDF</button>
									</div>
								</form>
							</div>
						</center>
					</div>
				</div>
			</div>
		</div>
<?php
}
else{
	session_unset();
	session_destroy();
}
include('include/footer.php');
?>
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
		
		var strURL="findzonebox2.php?z_id="+afdId;
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