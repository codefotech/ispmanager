<?php
$titel = "Reports";
$Reports = 'active';
$ReportBillPrint = 'activeted';
include('include/hader.php');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(160, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

if($user_type == 'billing'){
$result=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND FIND_IN_SET('$e_id', emp_id) > 0 order by z_name");
$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND FIND_IN_SET('$e_id', emp_id) > 0 order by z_name");
$result2=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND FIND_IN_SET('$e_id', emp_id) > 0 order by z_name");
}else{
$result=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
$result2=mysql_query("SELECT z.z_id, z.z_name, z.e_id, z.emp_id, e.e_name, z.status FROM `zone` AS z
					LEFT JOIN emp_info AS e ON e.e_id = z.emp_id WHERE z.status = '0' AND z.e_id = '' AND z.emp_id != '' GROUP BY z.emp_id order by z.z_name");

$result20=mysql_query("SELECT * FROM emp_info WHERE dept_id != '0' AND status = '0' order by e_name");
}

if($userr_typ == 'mreseller'){
	$resultsgsg=mysql_query("SELECT box_id, b_name FROM `box` WHERE `z_id` = $macz_id");
}
?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Due Bill</h1>
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
					<div class="box-body" style="min-height: 440px;">
					<?php if($userr_typ == 'mreseller'){ ?>
							<center>
						<h4>Bill Print</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<input type="hidden" name="z_id" id="" readonly value="<?php echo $macz_id; ?>" />
									<input type="hidden" name="way" id="" value="macreseller" />
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="box_id" class="chzn-select"  style="width:345px;" onChange="getRoutePoint(this.value)">
											<option value="all"> All Zone </option>
												<?php while ($rowaf=mysql_fetch_array($resultsgsg)) { ?>
											<option value="<?php echo $rowaf['box_id']?>"><?php echo $rowaf['b_name']; ?></option>
												<?php } ?>
										</select>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:345px;">
											<option value="all">All Payment Method</option>
											<option value="Cash">Cash</option>
											<option value="Cash from Home">Cash from Home</option>
											<option value="Office">Office</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
										</select>
									</div>
									<div class="animate_cus3">
										<input class="btn" style='width: 45%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportBillPrint';"/>
										<input class="btn" style='width: 45%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportBillPrint';"/>
									</div>
								</form>
								
							</div>
						</center>
					<?php } else{ ?>
					
						<center>
						<h4>Due Bill Print</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
								<input type="hidden" name="user_type" id="" readonly value="<?php echo $user_type; ?>" />
								<input type="hidden" name="e_id" id="" readonly value="<?php echo $e_id; ?>" />
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;" onChange="getRoutePoint(this.value)">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?></option>
												<?php } ?>
										</select>
										
									</div>
									<div id="Pointdiv1">
										<input type="hidden" name="box_id" id="" readonly value="all" />
									</div>
									<div class="inputwrapper animate_cus2">
										<div id="custdiv">
											<select data-placeholder="Choose a Status" name="con_sts" class="chzn-select"  style="width:345px;">
												<option value="all"> All Status </option>
												<option value="active">Active</option>
												<option value="inactive">Inactive</option>
											</select>
										</div>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:345px;">
											<option value="all">All Payment Method</option>
											<option value="Cash">Cash</option>
											<option value="Cash from Home">Cash from Home</option>
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
										<select data-placeholder="Connection Status" name="sts" class="chzn-select"  style="width:345px;">
											<option value="all"> All Status </option>
											<option value="1">Deleted</option>
											<option value="0" selected>Not Deleted</option>
										</select>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Connection Status" name="partial" class="chzn-select"  style="width:345px;">
											<option value="all"> All Due </option>
											<option value="1">Partial Due</option>
											<option value="2">Not Partial Due</option>
										</select>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Deadline" name="df_date" class="chzn-select"  style="width:100px;">
											<option value="all"> From Deadline </option>
											<option value="01"> 1</option>
											<option value="02"> 2</option>
											<option value="03"> 3</option>
											<option value="04"> 4</option>
											<option value="05"> 5</option>
											<option value="06"> 6</option>
											<option value="07"> 7</option>
											<option value="08"> 8</option>
											<option value="09"> 9</option>
											<option value="10"> 10</option>
											<option value="11"> 11</option>
											<option value="12"> 12</option>
											<option value="13"> 13</option>
											<option value="14"> 14</option>
											<option value="15"> 15</option>
											<option value="16"> 16</option>
											<option value="17"> 17</option>
											<option value="18"> 18</option>
											<option value="19"> 19</option>
											<option value="20"> 20</option>
											<option value="21"> 21</option>
											<option value="22"> 22</option>
											<option value="23"> 23</option>
											<option value="24"> 24</option>
											<option value="25"> 25</option>
											<option value="26"> 26</option>
											<option value="27"> 27</option>
											<option value="28"> 28</option>
											<option value="29"> 29</option>
											<option value="30"> 30</option>
											<option value="31"> 31</option>
										</select>
										<select data-placeholder="Choose a Deadline" name="dt_date" class="chzn-select"  style="width:100px;">
											<option value="all"> To Deadline </option>
											<option value="01"> 1</option>
											<option value="02"> 2</option>
											<option value="03"> 3</option>
											<option value="04"> 4</option>
											<option value="05"> 5</option>
											<option value="06"> 6</option>
											<option value="07"> 7</option>
											<option value="08"> 8</option>
											<option value="09"> 9</option>
											<option value="10"> 10</option>
											<option value="11"> 11</option>
											<option value="12"> 12</option>
											<option value="13"> 13</option>
											<option value="14"> 14</option>
											<option value="15"> 15</option>
											<option value="16"> 16</option>
											<option value="17"> 17</option>
											<option value="18"> 18</option>
											<option value="19"> 19</option>
											<option value="20"> 20</option>
											<option value="21"> 21</option>
											<option value="22"> 22</option>
											<option value="23"> 23</option>
											<option value="24"> 24</option>
											<option value="25"> 25</option>
											<option value="26"> 26</option>
											<option value="27"> 27</option>
											<option value="28"> 28</option>
											<option value="29"> 29</option>
											<option value="30"> 30</option>
											<option value="31"> 31</option>
										</select>
									</div>
									<!--
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Deadline" name="df_date" class="chzn-select"  style="width:145px;">
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
										<select data-placeholder="Choose a Deadline" name="dt_date" class="chzn-select"  style="width:145px;">
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
									</div>--->
									<div class="animate_cus3">
										<input class="btn ownbtn2" style='width: 35%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportBillPrint';"/>
										<input class="btn ownbtn3" style='width: 35%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportBillPrint';"/>
									</div>
								</form>
								
							</div>
						</center>
						<br /><br /><br />
						<?php if($userr_typ != 'billing'){ ?>
						<center>
						
						<h4>Due Bill Print (Bill Man Wise)</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="fpdf/ReportBillPrintBillman" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Bill Man" name="bill_man" class="chzn-select"  style="width:345px;">
											<option value="all"> All Bill Man </option>
												<?php while ($row55=mysql_fetch_array($result20)) { ?>
											<option value="<?php echo $row55['e_id']?>"><?php echo $row55['e_name']; ?></option>
												<?php } ?>
										</select>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:345px;">
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
									<div class="animate_cus3">
										<button class="btn ownbtn2" style='width: 70%;' type="submit">PDF</button>
									</div>
								</form>
								
							</div>
						</center>
						<br /><br /><br />
						
						<center>
						<h4>Due Bill Print (Employee Wise)</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<input type="hidden" name="way" id="" value="not_macreseller" />
									<div class="inputwrapper animate_cus1">
									<?php if($userr_typ == 'billing'){ ?>
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
												<?php while ($row=mysql_fetch_array($result2)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?></option>
												<?php } ?>
										</select>
									<?php } else{?>
										<select data-placeholder="Choose an Employee" name="emp_id" class="chzn-select"  style="width:345px;">
											<option value="all"> All Employee </option>
												<?php while ($row2=mysql_fetch_array($result2)) { ?>
											<option value="<?php echo $row2['emp_id']?>"><?php echo $row2['e_name']; ?> (<?php echo $row2['emp_id']; ?>)</option>
												<?php } ?>
										</select>
										<?php } ?>
									</div>
									<div class="inputwrapper animate_cus2">
										<div id="custdiv">
											<select data-placeholder="Choose a Status" name="con_sts" class="chzn-select"  style="width:345px;">
												<option value="all"> All Status </option>
												<option value="active">Active</option>
												<option value="inactive">Inactive</option>
											</select>
										</div>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:345px;">
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
										<select data-placeholder="Connection Status" name="sts" class="chzn-select"  style="width:345px;">
											<option value="all"> All Status </option>
											<option value="1">Deleted</option>
											<option value="0">Not Deleted</option>
										</select>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Connection Status" name="partial" class="chzn-select"  style="width:345px;">
											<option value="all"> All Due </option>
											<option value="1">Partial Due</option>
											<option value="2">Not Partial Due</option>
										</select>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Deadline" name="df_date" class="chzn-select"  style="width:100px;">
											<option value="all"> From Deadline </option>
											<option value="01"> 1</option>
											<option value="02"> 2</option>
											<option value="03"> 3</option>
											<option value="04"> 4</option>
											<option value="05"> 5</option>
											<option value="06"> 6</option>
											<option value="07"> 7</option>
											<option value="08"> 8</option>
											<option value="09"> 9</option>
											<option value="10"> 10</option>
											<option value="11"> 11</option>
											<option value="12"> 12</option>
											<option value="13"> 13</option>
											<option value="14"> 14</option>
											<option value="15"> 15</option>
											<option value="16"> 16</option>
											<option value="17"> 17</option>
											<option value="18"> 18</option>
											<option value="19"> 19</option>
											<option value="20"> 20</option>
											<option value="21"> 21</option>
											<option value="22"> 22</option>
											<option value="23"> 23</option>
											<option value="24"> 24</option>
											<option value="25"> 25</option>
											<option value="26"> 26</option>
											<option value="27"> 27</option>
											<option value="28"> 28</option>
											<option value="29"> 29</option>
											<option value="30"> 30</option>
											<option value="31"> 31</option>
										</select>
										<select data-placeholder="Choose a Deadline" name="dt_date" class="chzn-select"  style="width:100px;">
											<option value="all"> To Deadline </option>
											<option value="01"> 1</option>
											<option value="02"> 2</option>
											<option value="03"> 3</option>
											<option value="04"> 4</option>
											<option value="05"> 5</option>
											<option value="06"> 6</option>
											<option value="07"> 7</option>
											<option value="08"> 8</option>
											<option value="09"> 9</option>
											<option value="10"> 10</option>
											<option value="11"> 11</option>
											<option value="12"> 12</option>
											<option value="13"> 13</option>
											<option value="14"> 14</option>
											<option value="15"> 15</option>
											<option value="16"> 16</option>
											<option value="17"> 17</option>
											<option value="18"> 18</option>
											<option value="19"> 19</option>
											<option value="20"> 20</option>
											<option value="21"> 21</option>
											<option value="22"> 22</option>
											<option value="23"> 23</option>
											<option value="24"> 24</option>
											<option value="25"> 25</option>
											<option value="26"> 26</option>
											<option value="27"> 27</option>
											<option value="28"> 28</option>
											<option value="29"> 29</option>
											<option value="30"> 30</option>
											<option value="31"> 31</option>
										</select>
									</div>
									<div class="animate_cus3">
										<input class="btn ownbtn2" style='width: 35%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportBillPrintEmployee';"/>
										<input class="btn ownbtn3" style='width: 35%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportBillPrintEmployee';"/>
									</div>
								</form>
								
							</div>
						</center>
						<br />
					<?php }} ?>
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