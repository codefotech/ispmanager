<?php
$titel = "Bill Print";
$Billing = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$type = $_GET['id'];
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$result = mysql_query("SELECT z_id, z_name FROM zone ORDER BY z_name");
?>
	<div class="pageheader">
		<div class="searchbar">
			<a class="btn btn-primary" href="GenerateNewBills"><i class="iconfa-plus"></i> Generate New Bills </a>			<a class="btn btn-primary" href="BillsPrint"><i class="iconfa-print"></i> Print Bills </a>			<a class="btn btn-neveblue" href="Billing?id=all"><i class="iconfa-user"></i> Payable Bills </a>			<a class="btn btn-green" href="Billing?id=payment"><i class="iconfa-ok"></i> Payment Bills </a>			<a class="btn btn-red" href="Billing?id=due"><i class="iconfa-warning-sign"></i> Due Bills </a>			<!-- <a class="btn btn-danger" href="Billing?id=new"><i class="iconfa-lock"></i> New Signup Bills </a> -->
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Bill Printing</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary" style="min-height: 510px;">
		<div class="box-header">
			<h5><?php echo $tit; ?></h5>
		</div>
			<div class="box-body">
				<form id="" name="form" class="stdform" method="POST" action="fpdf/BillsPrint" target="_blank">	
					<input type="hidden" name="user_type" value="<?php echo $user_type; ?>" />	
					<input type="hidden" name="e_id" value="<?php echo $e_id; ?>" />
					<div class="par center">
						<div class="input-append">
							<select data-placeholder="Choose Year" name="year" style="width:200px;" class="chzn-select">
								<option value=""></option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
							</select>
							<select data-placeholder="Choose Month" name="month" style="width:200px;" class="chzn-select">
								<option value=""></option>
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
									
							</select>
							<select data-placeholder="Choose Zone" name="z_id" style="width:200px;" class="chzn-select">
								<option value=""></option>
								<option value="all">All Zone</option>
									<?php while ($row = mysql_fetch_array($result)) { ?>
								<option value=<?php echo $row['z_id']?>><?php echo $row['z_name']?></option>
									<?php } ?>
							</select>
							<button class="btn" style="height: 34px;" type="submitt">Submit</button>
						</div>
					</div>
				</form>
			</div>			
	</div>

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
				
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>