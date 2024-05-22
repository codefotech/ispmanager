<?php
$titel = "Network Diagram";
$NetworkTree = 'active';
include('include/hader.php');
include('include/telegramapi.php');
include("mk_api.php");
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'NetworkTree' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql360 = mysql_query("SELECT d.id, d.d_name AS devicename, COUNT(n.device_type) AS devi, d.icon FROM network_tree AS n 
LEFT JOIN device AS d ON d.id = n.device_type
WHERE n.sts = '0' AND n.device_sts = '0' GROUP BY n.device_type ORDER BY COUNT(n.device_type) ASC");

$sql3 = mysql_query("SELECT n.tree_id as idee, n.parent_id, n.in_port, n.ip, n.ping, n.mk_id, d.id, n.in_color as style, n.in_color as style1, '2' as sizee, n.out_port, n.fiber_code, n.z_id, n.box_id as weightt, d.d_name, n.name, n.location, n.g_location, n.note FROM network_tree AS n
LEFT JOIN device AS d ON d.id = n.device_type
order by n.tree_id");

$myurl[]="['id', 'name', 'parent', 'Out', 'Color', { role: 'style' }]";
while($r3=mysql_fetch_assoc($sql3)){
	
	$idss = $r3['idee'];
	$ipss = $r3['ip'];
	$ip= strip_tags($ipss);
	
	$name = $r3['name'];
	$parent_id = $r3['parent_id'];
	$sizeee = $r3['sizee'];
	

	$in_port = $r3['in_port'];
	$out_port = $r3['out_port'];
	$location = $r3['location'];
	$d_name = $r3['d_name'];
	$ping = $r3['ping'];
	$mk_id = $r3['mk_id'];
	
if($ping == '1' && $tele_sts == '0' && $tele_onu_ping_check == '0'){
$telete_way = 'onu_ping';
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;
	
    if ($API->connect($ServerIP, $Username, $Pass, $Port)) {

$arrID = $API->comm("/ping", array(
            "address" => $ip,
            "arp-ping" => "no",
            "count" => "5",
            "interval" => "100ms"
        ));

		$x = 0;	
		$ss = 0;	
		$okcountt = 0;	
		foreach($arrID as $x => $x_value) {
			$received = $x_value['received'];
			$host = $x_value['host'];
			$size = $x_value['size'];
			$ttl = $x_value['ttl'];
			$time = $x_value['time'];
			$status = $x_value['status'];
			if($status == 'timeout'){
				$statuss = 'request timed out';
				$count = '1';
				$okcount = '0';
			}
			else{
				$statuss = 'OK';
				$count = '0';
				$okcount = '1';
			}
			$x++;
			$ss += $count;
			$okcountt += $okcount;
		}
		$dfheh = $ss*100/$x;
		$fghfghf = number_format($dfheh,2);
		if($dfheh > '99'){
$hdfghh = $down_count+1;
$msg_body='..::[Device Down]::..
IP Address: '.$ip.'
Name: '.$name.'
Type: '.$d_name.'
count: '.$hdfghh.'

'.$tele_footer.'';
include('include/telegramapicore.php');

$queryee = "UPDATE ip_checker SET down_count = '$hdfghh' WHERE id = '$id'";
$sqlss = mysql_query($queryee);

$weightttt = 'red';
$inport = 'red';
}
else{
$weightttt = $r3['style'];	
$inport = $r3['style1'];		
}
}else{echo 'Selected Network are not Connected.';}

}
	else{
$weightttt = $r3['style'];	
$inport = $r3['style1'];
	}
	$myurl[]="[".$idss.", '".$idss.'.'.$name.'-'.$d_name."', ".$parent_id.", ".$sizeee.", '".$inport."', '".$weightttt."']";
}

$queryff="SELECT t.tree_id, t.device_type, t.name AS devicename, t.parent_id, z.z_name, t.location, t.in_color, d.d_name, d.icon, a.distance_km, a.distance_miles FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type LEFT JOIN zone AS z ON z.z_id = t.z_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.sts = '0' AND t.parent_id = '0'";
$resultff=mysql_query($queryff);
?>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:['wordtree']});
      google.charts.setOnLoadCallback(drawSimpleNodeChart);
      function drawSimpleNodeChart() {
        var nodeListData = new google.visualization.arrayToDataTable([
          <?php echo(implode(",",$myurl));?>
			]);

        var options = {
		maxFontSize: 15,
          wordtree: {
            format: 'explicit',
            type: 'suffix'
          }
        };

        var wordtree = new google.visualization.WordTree(
          document.getElementById('wordtree_explicit_maxfontsize'));
        wordtree.draw(nodeListData, options);
      }
    </script>
	<div class="pageheader">
        <div class="searchbar">
			<?php if($tree_sts_permission == '0'){ ?><a class="btn ownbtn3" href="NetworkTreeMap">Map View</a><?php } ?>
			<a class="btn ownbtn2" href="ClientsOnMap" target='_blank'>Clients On Map</a>
			<a class="btn ownbtn3" href="NetworkDeviceOnMap" target='_blank'>Device On Map</a>
			<a class="btn ownbtn1" href="NetworkTreeList">Device List</a>
			<a class="btn ownbtn2" href="NetworkTreeAdd">Add Device</a>
        </div>
        <div class="pageicon"><i class="iconfa-sitemap"></i></div>
        <div class="pagetitle">
            <h1>Network Diagram</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
			<div id="hd">
			<span id="resultpackall">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100%;">
                    <colgroup>
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center" style="width: 3%;">ID</th>
							<th class="head0">Device Type</th>
							<th class="head1 center">ICON</th>
							<th class="head0">Total Count</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $rowwqq = mysql_fetch_assoc($sql360) )
								{
									echo
										"<tr class='gradeX'>
											<td class='center' style='font-size: 17px;font-weight: bold;color: darkred;'>{$rowwqq['id']}</td>
											<td style='font-size: 17px;font-weight: bold;color: darkred;'>{$rowwqq['devicename']}</td>
											<td class='center'><img src='/{$rowwqq['icon']}' width='25' height='30' alt='' /></td>
											<td style='font-size: 17px;font-weight: bold;color: green;'>{$rowwqq['devi']}</td>
											<td class='center' style='width: 100px !important;'>
												<ul class='tooltipsample'>
													<li><form action='NetworkDeviceOnMap' method='post' target='_blank'><input type='hidden' name='d_type' value='{$rowwqq['id']}' /><button class='btn' style='border-radius: 3px;border: 1px solid #0866c6;color: #0866c6;padding: 6px 9px;' title='View Device On Map'><i class='iconfa-eye-open'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
				</span>
			</div>
			
			</div>
			<div class="modal-content" style="border-bottom: 2px solid #3c8dbc;">
				<div class="modal-body" style="padding: 5px;">
					<table style="width: 100%;border-bottom: 0px;" class="table table-bordered responsive">
						<thead>
						  <tr>
							<td class='center' style="width: 15%;padding: 0px;font-size: 13px;font-weight: bold;">
								<select name="node1" style="width:100%;" data-placeholder="Select a Zone" id="node1" class="chzn-select">
									<option style="text-align: Left;" value="all">All Node</option>
									<?php while ($rowz=mysql_fetch_array($resultff)) { ?>
										<option style="text-align: Left;" value="<?php echo $rowz['tree_id']?>"><?php echo $rowz['tree_id']?> - <?php echo $rowz['devicename']; echo ' - '.$rowz['d_name']; echo ' - '.$rowz['z_name'];?></option>
									<?php } ?>
								</select>
							</td>
							
							
							<select name="resultpack" id="resultpack">
								<option value="">--Select Subcategory--</option>
							</select>
							
							<td class='center' style="width: 10%;padding: 0px;"><input type="text" name="f_date" value="<?php echo $f_date;?>" placeholder="Date From" style="text-align: center;width: 80%;font-size: 13px;font-weight: bold;" id="f_date" class="datepicker"></td>
							<td class='center' style="width: 10%;padding: 0px;"><input type="text" name="t_date" value="<?php echo $t_date;?>" placeholder="Date To" style="text-align: center;width: 80%;font-size: 13px;font-weight: bold;" id="t_date" class="datepicker"></td>
							
							<td class='center' style="width: 10%;padding: 0px;font-size: 13px;font-weight: bold;">
								<select name="sort_by" style="width:100%;" data-placeholder="Sort By" id="sort_by" class="chzn-select">
									<option style="text-align: Left;" value="hour" selected="selected">Hour</option>
									<option style="text-align: Left;" value="day">DAY</option>
									<!---<option style="text-align: Left;" value="month">MONTH</option>--->
								</select>
							</td>
							
							<td class='center' style="width: 10%;padding: 0px;font-size: 13px;font-weight: bold;vertical-align: middle;">
								<form id="form2" class="stdform" method="post" action="<?php $PHP_SELF;?>">
								<select name="bill_month" class="" style="height: 30px;width: 80%;text-align: center;font-weight: bold;" onchange="submit();">
									<option value="<?php echo date("Y-m-01") ?>"><?php echo date("F-Y") ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
								</select>
							</form>
							</td>
						  </tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="box-body">
				<div id="wordtree_explicit_maxfontsize" style="width: 1400px; height: 1600px;"></div>
			</div>			
		</div>
<?php
}
else{
	header("Location:/index");
}
include('include/footer.php');
?>
<script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>
<style>
#google-visualization-errors-0{display: none;}
</style>
<script type="text/javascript">
jQuery(document).ready(function(){  
    jQuery("#resultpackall").load("network-tree-node.php?node1=all");
    jQuery('#node1, #box_id, #search_way, #f_date, #t_date, #sort_by, #Pointdiv1').on('change',function(){ 
        var node1 = jQuery('#node1').val();
        jQuery.ajax({  
				type: 'GET',
                url: "network-tree-node-loop.php",
                data:{node1:node1},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
        });  
        jQuery.ajax({  
				type: 'GET',
                url: "network-tree-node.php",
                data:{node1:node1},
                success:function(data){
                    jQuery('#resultpackall').html(data);
                }
        });  
    });  
});
</script>
