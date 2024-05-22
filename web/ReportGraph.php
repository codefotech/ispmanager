<?php
$titel = "Report Graph";
$ReportGraph = 'active';
include('include/hader.php');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'ReportGraph' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------


$user_type = $_SESSION['SESS_USER_TYPE'];

$sql1 = mysql_query("SELECT COUNT(id) AS TotalClients FROM clients");
$row1 = mysql_fetch_array($sql1);

$sql2 = mysql_query("SELECT COUNT(con_sts) AS TotalActive FROM clients WHERE con_sts = 'Active'");
$row2 = mysql_fetch_array($sql2);

$sql3 = mysql_query("SELECT COUNT(id) AS packages FROM package WHERE sts = '0'");
$row3 = mysql_fetch_array($sql3);

$inactive = $row1['TotalClients'] - $row2['TotalActive'];

$sql = mysql_query("SELECT DATE_FORMAT(c.join_date,'%d-%m') AS dat, COUNT(c.c_id) AS total FROM clients AS c
WHERE c.join_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND c.sts = '0'
GROUP BY c.join_date");

$myurl[]="['dat','total']";
while($r=mysql_fetch_assoc($sql)){
	
	$Item = $r['dat'];
	$Total = $r['total'];
	$myurl[]="['".$Item."',".$Total."]";
}
?>

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
				title: "Last 30 Days New Clients",
				height: 410,
				Width: '100%',
				vAxis: {title: 'New Clients'},
				hAxis: {title: 'Newly joind Clients in Last 30 days'},
				bar: {groupWidth: "65%"},
				fontSize: 12,
				legend: { position: "none" },
				chartArea: {'backgroundColor':'#fff'},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
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
            <h1>Graph Reports</h1>
        </div>
    </div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="span3 profile-left" style="">
				<div class="list-group">
					<?php require('include/ReportGraph_menu.php'); ?>
				</div>
			</div>
			<div class="span9 rightside" style="width: 74% !important; margin-left: 15px !important;">
				<div class="box box-primary" style=" margin: 0px;">
					<div class="box-body" style="min-height: 640px;">
						<div class="rightside" style="width: 100% !important; padding: 0px 0px 30px 0px;float: left;">
							<div id="chart_div" style="text-align: center; height: 410px; margin: 0 auto; padding: 0 auto;border: 2px solid #00A65A;"></div>
						</div>
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