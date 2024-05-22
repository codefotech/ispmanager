<?php
$titel = "Reports";
$Reports = 'active';
$ReportRevenue = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$date = date("Y-m-d");
$t_date = date('Y-m-01', strtotime($tdate));
$f_date = date('Y-m-t', strtotime($tdate));

$e_id = $_SESSION['SESS_EMP_ID'];

$result=mysql_query("SELECT * FROM zone WHERE status = '0' order by z_name");


	$query = mysql_query("SELECT z.z_name as Territory, SUM(b.bill_amount) AS Total FROM billing AS b 
								LEFT JOIN clients AS c ON c.c_id = b.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE b.bill_date BETWEEN '$t_date' AND '$f_date'
								GROUP BY c.z_id");
			
$tname = 'All Deviation';	
$tit = 'All Deviation';
$myurl[]="['Territory','Total']";
while($r=mysql_fetch_assoc($query)){
	
	$Item = $r['Territory'];
	$Total = $r['Total'];
	$myurl[]="['".$Item."',".$Total."]";
}
	
?>
<!-- --------------------------------------------------Month Picker------------------------------------------------ -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>

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
				title: "Deviational Sales Ratio <?php echo $tname;?>",
				height: 450,
				vAxis: {title: 'Total Sales Litter'},
				hAxis: {title: '<?php echo $tit; ?>'},
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
<!-- -------------------------------------------------------------------------------------------------- -->

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Reports</h1>
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
					<div class="mediamgr_left">
								<div id="chart_div" style="width: 100%; text-align: center; height: 800px; margin: 0 auto; padding: 0 auto"></div>
							</div><!--mediamgr_left -->
						<center>
						<h4> Revenue Report </h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="fpdf/ReportRevenue" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
												<?php } ?>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus4">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" placeholder="From Date"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" placeholder="To Date"/>
										</div>
									</div>
									<div class="animate_cus3">
										<button class="btn ownbtn2" style='width: 30%;' type="submit">SUBMIT</i></button>
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
	include('include/index');
}
include('include/footer.php');
?>