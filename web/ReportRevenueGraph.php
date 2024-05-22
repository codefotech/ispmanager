<?php
$titel = "Reports Graph";
$ReportGraph = 'active';
$ReportRevenueGraph = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'ReportGraph' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$date = date("Y-m-d");
$t_date = date('Y-m-01', strtotime($tdate));
$f_date = date('Y-m-t', strtotime($tdate));

if($t_id == 'all'){
		$query = mysql_query("SELECT CONCAT(z.z_name,' - ',z.z_bn_name) AS item, SUM(b.bill_amount) AS tot FROM billing AS b 
								LEFT JOIN clients AS c ON c.c_id = b.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE b.bill_date BETWEEN '$t_date' AND '$f_date'
								GROUP BY c.z_id");
		$tname = 'Revenue Ratio in All Zone';
		
}
else{
	$query = mysql_query("SELECT CONCAT(p.p_name,' - ',p.bandwith) AS item, SUM(b.bill_amount) AS tot FROM billing AS b 
								LEFT JOIN clients AS c ON c.c_id = b.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								LEFT JOIN package AS p
								ON p.p_id = c.p_id
								WHERE b.bill_date BETWEEN '$t_date' AND '$f_date' AND c.z_id = '$t_id'
								GROUP BY p.bandwith ORDER BY p.p_id ASC");
			
	$result2 = mysql_query("SELECT z_id, z_name FROM zone WHERE z_id = '$t_id'");
	$ros = mysql_fetch_assoc($result2);
	if($t_id == ''){
		$tname = "Choose Month and Zone Please";
	}
	else{
	$tname = "Revenue Ratio in ".$ros['z_name'];
	}
}

$myurl[]="['item','tot']";
while($r=mysql_fetch_assoc($query)){
	
	$Item = $r['item'];
	$Total = $r['tot'];
	$myurl[]="['".$Item."',".$Total."]";
}


$result=mysql_query("SELECT * FROM zone WHERE status = '0' order by z_name");

?>

<!-- --------------------------------------------------Month Picker------------------------------------------------ -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
	<script type="text/javascript">
		$(function() {
			$('.date-picker').datepicker( {
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'MM yy',
				onClose: function(dateText, inst) { 
					var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					$(this).datepicker('setDate', new Date(year, month, 1));
				}
			});
		});
	</script>
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
			var options = {'title':'<?php echo $tname;?> <?php echo $tdate;?>',
							//is3D:true,
							pieHole: 0.4,
							'allowHtml': true};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		  }
    </script>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Revenue Graph</h1>
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
					<div class="box-body" style="min-height: 440px;">
						<div class="mediamgr">
							<div class="mediamgr_left">
								<div id="chart_div" style="width: 100%; text-align: center; height: 600px; margin: 0 auto; padding: 0 auto"></div>
							</div><!--mediamgr_left -->
							
							<div class="mediamgr_right" style="top: 0px !important;">
								<form method="post" action="<?php echo $PHP_SELF;?>">
									<div class="mediamgr_rightinner" style="margin: 10px 0 !important; padding-left: 10px !important;">
										<ul class="menuright">
											<li>
												<input style="text-align: center; width: 216px;" type="text" name="tdate" id="startDate" class="date-picker" value="<?php echo date("F Y");?>" />
											</li>
											<li>
												<span class="formwrapper">
													<select id="dropdown_graph" style="text-align: center; width:230px; margin-top: 5px;" name="t_id" onchange="submit();" class="select-xlarge" >
														<option value="all">Choose A Zone</option>
														<option value="all" <?php if( $t_id == 'all') {echo 'selected';} ?>>All Zone</option>
															<?php while ($row=mysql_fetch_array($result)) { ?>
														<option value="<?php echo $row['z_id']?>"<?php if( $row['z_id'] == $ros['z_id']) {echo 'selected';} ?>><?php echo $row['z_name']?></option>
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