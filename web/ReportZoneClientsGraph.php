<?php
$titel = "Report Zone Clients Graph";
$ReportGraph = 'active';
$ReportZoneClientsGraph = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'ReportGraph' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

if($z_id == 'all' || $z_id == ''){
		$query = mysql_query("SELECT CONCAT(z.z_name,' - ',z.z_bn_name) AS Territory, count(c.c_id) AS Total FROM zone AS z
								LEFT JOIN clients AS c ON c.z_id = z.z_id
								WHERE c.sts = '0'
								GROUP BY z.z_id");
		/*
			SELECT t.t_name AS Territory, SUM(d.d_total) AS Total FROM order_phone_master AS m
					LEFT JOIN delivery_details AS d ON d.d_ord_no = m.p_ord_no
					LEFT JOIN territory_info AS t ON t.t_id = m.p_tre_id
					WHERE m.d_del_date BETWEEN '$t_date' AND '$f_date'
					GROUP BY m.p_tre_id ORDER BY t.t_name");
		*/			
		$tname = '';	
		$tit = 'Zone All Clients';
}
else{
	$query = mysql_query("SELECT CONCAT(p.p_name,' - ',p.bandwith,' - ',p.p_price,'TK') AS Territory, count(c.c_id) AS Total FROM clients AS c
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE c.z_id = '$z_id' AND c.sts = '0'
							GROUP BY c.p_id ORDER BY p.p_id");
			
	$result2 = mysql_query("SELECT z_name FROM zone WHERE z_id = '$z_id'");
	$ros = mysql_fetch_assoc($result2);
	$tname = $ros['z_name'];
	$tit = 'All Clients in Zone: '.$tname.' & Packages.';
}

$myurl[]="['Territory','Total']";
while($r=mysql_fetch_assoc($query)){
	
	$Item = $r['Territory'];
	$Total = $r['Total'];
	$myurl[]="['".$Item."',".$Total."]";
}			

$result=mysql_query("SELECT * FROM zone WHERE status = '0' order by z_name");

?>

<!-- --------------------------------------------------Month Picker------------------------------------------------ -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
<!-- -------------------------------------------------------------------------------------------------- -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script> 

	<script type="text/javascript">

		  // Load the Visualization API and the piechart package.
		  google.load('visualization', '1.0', {'packages':['corechart']});

		  // Set a callback to run when the Google Visualization API is loaded.
		  google.setOnLoadCallback(drawChart);

		  // Callback that creates and populates a data table,
		  // instantiates the pie chart, passes in the data and
		  // draws it.
		  function drawChart() {

			// Create the data table.
			var data = new google.visualization.arrayToDataTable([
				<?php echo(implode(",",$myurl));?>
			]);
		

			// Set chart options
			
			var options = {
				title: "Zone Wise Clients Counting <?php echo $tname;?>",
				height: 450,
				vAxis: {title: 'Zone Wise Clients Counting'},
				hAxis: {title: '<? echo $tit; ?>'},
				bar: {groupWidth: "75%"},
				fontSize: 12,
				legend: { position: "none" },
				colors: ['#1b9e77']
			  };				

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		  }
    </script>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Zone Clients Graph</h1>
        </div>
    </div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="span3 profile-left" style="">
				<div class="list-group">
					<?php require('include/ReportGraph_menu.php'); ?>
				</div>
			</div>
			<div class="span9 rightside" style="width: 74% !important; margin-left: 10px !important;">
				<div class="box box-primary" style=" margin: 0px;">
					<div class="box-body" style="min-height: 350px;">
						<div class="mediamgr">
							<div class="mediamgr_left">
								<div id="chart_div" style="width: 100%; text-align: center; height: 600px; margin: 0 auto; padding: 0 auto"></div>
							</div><!--mediamgr_left -->
							
							<div class="mediamgr_right" style="top: 0px !important;">
								<form method="post" action="<?php echo $PHP_SELF;?>">
									<div class="mediamgr_rightinner" style="margin: 10px 0 !important; padding-left: 10px !important;">
										<ul class="menuright">
											<li>
												<span class="formwrapper">
													<select id="dropdown_graph" style="text-align: center; width:230px; margin-top: 5px;" name="z_id" onchange="submit();" class="select-xlarge" >
														<option value="all">Choose A Zone</option>
														<option value="all" <?php if( $t_id == 'all') {echo 'selected';} ?>>All Zone</option>
															<?php while ($row=mysql_fetch_array($result)) { ?>
														<option value="<?php echo $row['z_id']?>"<?php if( $row['z_id'] == $z_id) {echo 'selected';} ?>><?php echo $row['z_name']?> - <?php echo $row['z_bn_name']?></option> 
														<?php } ?>
													</select>
												</span>
											</li>
										</ul>
									</div><!-- mediamgr_rightinner -->
								</form>
							</div><!-- mediamgr_right -->
						</div><!--mediamgr-->
					</div>
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