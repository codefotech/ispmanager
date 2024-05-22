<?php
$titel = "Reports Graph";
$ReportGraph = 'active';
$ReportCollectionGraph = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'ReportGraph' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$date = date("Y-m-d");
$t_date = date('Y-m-t', strtotime($tdate));
$f_date = date('Y-m-t', strtotime($fdate));

if($t_id == 'all'){
		$query = mysql_query("SELECT DATE_FORMAT(pay_date,'%d %b %y') AS item, SUM(p.pay_amount) AS Collection, SUM(p.bill_discount) AS Discount
								FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								WHERE p.pay_date BETWEEN '$t_date' AND '$f_date'
								GROUP BY p.pay_date");
		$tname = 'All Zone';
		
}
else{
	$query = mysql_query("SELECT DATE_FORMAT(pay_date,'%d %b %y') AS item, SUM(p.pay_amount) AS Collection, SUM(p.bill_discount) AS Discount
								FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								WHERE p.pay_date BETWEEN '$t_date' AND '$f_date' AND c.z_id = '$t_id'
								GROUP BY p.pay_date");
			
	$result2 = mysql_query("SELECT z_id, z_name FROM zone WHERE z_id = '$t_id'");
	$ros = mysql_fetch_assoc($result2);
	if($t_id == ''){
		$tname = "Choose Month and Zone Please";
	}
	else{
	$tname = "Revenue Ratio in ".$ros['z_name'];
	}
}

$myurl[]="['item','Collection','Discount']";
while($r=mysql_fetch_assoc($query)){
	
	$Item = $r['item'];
	$Total = $r['Collection'];
	$dis = $r['Discount'];
	$myurl[]="['".$Item."',".$Total.",".$dis."]";
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl));?>
        ]);

        var options = {
          title: '<?php echo $tname;?> <?php echo $tdate;?> to <?php echo $fdate;?>',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

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
								<div id="curve_chart" style="width: 900px; height: 500px"></div>

							</div><!--mediamgr_left -->
							
							<div class="mediamgr_right" style="top: 0px !important;">
								<form method="post" action="<?php echo $PHP_SELF;?>">
									<div class="mediamgr_rightinner" style="margin: 10px 0 !important; padding-left: 10px !important;">
										<ul class="menuright">
											<li>
												<input style="text-align: center; width: 43%;" type="text" name="tdate" id="startDate" class="date-picker" value="<?php echo $tdate;?>" />
												<input style="text-align: center; width: 43%;" type="text" name="fdate" id="endDate" class="date-picker" value="<?php echo $fdate;?>" />
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