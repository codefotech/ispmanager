
<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!

$titel = "Mac Reseller Clients Multi Recharge";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
$mk_id = isset($_GET['id']) ? $_GET['id'] : '';
$input = isset($_GET['input']) ? $_GET['input'] : '';
$z_id = isset($_GET['zid']) ? $_GET['zid'] : '';
extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$result = mysql_query("SELECT z.z_id, z.z_name, z.e_id as reseller_id, COUNT(c.c_id) AS totalclients, e.e_name, e.e_cont_per, e.pre_address, e.terminate, e.mk_id FROM zone AS z
						LEFT JOIN emp_info AS e	ON e.e_id = z.e_id
						LEFT JOIN clients AS c ON c.z_id = z.z_id
						WHERE z.z_id = '39' AND c.sts = '0'");
$row = mysql_fetch_array($result);	

$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, c.termination_date, c.mk_id, e.e_name AS technician, b.b_name AS z_name, c.b_date, c.c_id, c.payment_deadline, c.raw_download, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, p.p_price_reseller, c.address, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												WHERE c.sts = '0' AND z.z_id = '39' ORDER BY c.id DESC");
							$sqls = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND z_id = '39'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
									
$resultsdfg=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by e.e_name");

?>

	<div class="pageheader">
		<div class="searchbar" style="width: 50%;">
        </div>
        <div class="pageicon" style="padding: 2px;"><i class="iconfa-download-alt"></i></div>
        <div class="pagetitle">
             <h3 style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;">MAC Reseller Clients Recharge</h3>
			 
        </div>
		
    </div><!--pageheader-->		
		
		<div class="box box-primary">
		<!--
		<form name="form" class="" method="POST" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data">	
			<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 8px 0px 10px 15px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);overflow: auto;">
				<div style="float: left;">
				<input type="text" name="duration" id="duration" style="border: 1px solid red;color: red;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;border-radius: 3px;width: 40px;margin-left: 3px;font-weight: bold;font-size: 15px;height: 18px;" placeholder="days" class="surch_emp" value="<?php if($duration >= '0'){echo $duration;}?>" required=""/>
				&nbsp; &nbsp;&nbsp; &nbsp;
				</div>
					<button class="btn ownbtn4" type="submit" style="float: right;margin-right: 15px;">Submit</button>
			</div>
		</form>--->
			<div class="box-header" style="font-size: 14px;padding: 12px 0px 0px 15px;font-weight: bold;">
				[ Active:  <i style='color: #317EAC'><?php echo $ssss;?></i> ]    
				[ Inactive:  <i style='color: #317EAC'><?php echo $totlclients;?></i> ]&nbsp; &nbsp; &nbsp;
			</div>
			<div class="box-body" id="etheah">

			<table id="dyntable2" class="table table-bordered responsive">
				<colgroup>
                        <col class="con1" style='width: 8%;'/>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr class="newThead">
							<th class="head1 center" style='width: 8%;'>S/L</th>
							<th class="head0" style='width: 70%;'>PPPoE Info</th>
							<th class="head0 center" style='width: 5%;'>ACTION</th>
                        </tr>
                    </thead>
					
                    <tbody>
						<?php
						$aaa = 1;
							while( $row = mysql_fetch_assoc($sql) )
								{
									$activecountt += $activecount;
									$inactivecountt += $inactivecount;
									
									if($row['con_sts'] == 'Active'){
										$clss = 'act';
										$dd = 'Inactive';
										$ee = 'Active';
										$collllr = "style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;color:green; font-size: 14px;font-weight: bold;padding-top: 15px;'";
									}
									if($row['con_sts'] == 'Inactive'){
										$clss = 'inact';
										$dd = 'Active';
										$ee = 'Inactive';
										$collllr = "style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;color:red; font-size: 14px;font-weight: bold;padding-top: 15px;'";
									}
									
									$hhhh = $row['p_name'].' - '.$row['p_price'].'tk';
									
									$yrdata1= strtotime($row['termination_date']);
										$enddate = date('d F, Y', $yrdata1);
									
									$diff = abs(strtotime($row['termination_date']) - strtotime($dateTimeee))/86400;
									if($row['termination_date'] < $dateTimeee){ $diff = '0';}
									if($diff <= '7'){
										$colorrrraa = 'style="vertical-align: middle;color: red;font-weight: bold;"'; 
									}
									else{
										$colorrrraa = 'style="vertical-align: middle;font-weight: bold;"'; 
									}
									echo
										"<tr class='gradeX'>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;width: 5%;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$hhhh}&nbsp;&nbsp;<a {$collllr}'>{$ee}</a></b><br><b $colorrrraa><div id='olddatee{$aaa}'>{$enddate}&nbsp;&nbsp;&nbsp;&nbsp;LEFT: {$diff} Days</div></b></td>
											<td class='center' style='font-weight: bold;font-size: 13px;vertical-align: middle;width: 5%;'><div id='olddate{$aaa}'><button class='btn' id = 'addbttn{$aaa}' style='border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;margin: 2px 0 0 0;'>ADD</button></div></td>\n";
									 ?>
									<script>
										$(document).ready(function(){  
											$("#addbttn<?php echo $aaa;?>").on('click',function(){
												var duration = $('#duration').val();
												var c_id = '<?php echo $row['c_id'];?>';
												var p_id = '<?php echo $row['p_id'];?>';
												var p_price = '<?php echo $row['p_price'];?>';
												var z_id = '<?php echo $z_id;?>';
												var mk_id = '<?php echo $mk_id;?>';
												var con_sts = '<?php echo $row['con_sts'];?>';
												if(duration > 0){
												$.ajax({  
														type: 'POST',
														url: "mac-client-import-one-by-one",
														data:{duration:duration,c_id:c_id,p_id:p_id,p_price:p_price,z_id:z_id,mk_id:mk_id,con_sts:con_sts},
														success:function(data){
															data = JSON.parse(data);
															$('#olddate<?php echo $aaa;?>').html("<b>"+data.errormsg+"</b>");
															$('#olddatee<?php echo $aaa;?>').html("<b>"+data.resellernamee+" - "+data.z_name+"</b>");
														}
												});
												return false;

												}
												else{
													$('#olddate<?php echo $aaa;?>').html("");
												}
											});  
										});
										
									</script>
								<?php $aaa++; } ?>
					</tbody>
			</table>
		
			</div>
			</div>
		</div>
<div class="footmar" style="height: 45px;"><input type="text" name="duration" id="duration" style="border: 1px solid red;color: red;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;border-radius: 3px;width: 50px;margin-left: 3px;font-weight: bold;font-size: 20px;height: 20px;" placeholder="days" class="surch_emp" value="<?php if($duration >= '0'){echo $duration;}?>" required=""/></div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table

		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[0,'desc']],
            "sScrollY": "1100px"
        });
    });

function myFun() {
var x2=document.getElementById("t_date").value;
var x3=document.getElementById("f_date").value;
var msPerDay = 1000*60*60*24;
d1=new Date(x2);
d2=new Date(x3);
var x4=document.getElementById("duration");
var dd=( (((d1 - d2) / msPerDay)+1).toFixed(0) );
    x4.value=dd;
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
	
	function getRoutePoint(afdId) {		
		var strURL="import-reseller-client-one-by-one.php?z_id="+afdId;
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
		document.getElementById("t_date").value = ''		
		document.getElementById("duration").value = ''	
	}
	

$(document).ready(function()
{
$('select[name="z_id"]').on('change',function(){
 {  
  var name = $(this).val(); 
  if(name.length < 50)
  {
   $("#etheah").html('');
   $(".box-header").html('');
  }
 }
 });
 });
</script>
<style>
div.checker{
	margin-right: 0;
}
#dyntable_length{display: none;}
.footmar {
  bottom: 0;
  font-family: helvetica;
  padding: 0.1% 18px 0.2% 0.7%;
  position: fixed;
  right: 0px;
  top: 200px;
}
</style>