<?php
$titel = "My Schedule";
$ProductionWorkSchedule = 'active';
include('include/hader.php');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'ProductionWorkSchedule' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ZoneAddquery">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Zone Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Zone ID</div>
						<div class="col-2"><input style="text-align:center;" id="" type="text" readonly name="" class="input-xlarge" value="<?php echo $z_id;?>"></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Zone Name (English)</div>
						<div class="col-2"><input type="text" name="z_name" id="" placeholder="Write Name in English" class="input-xlarge" required="" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Bangla Name (Bangla)</div>
						<div class="col-2"><input type="text" name="z_bn_name" id="" placeholder="Write Name in Bangla" class="input-xlarge"/></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn">Reset</button>
				<button class="btn btn-primary" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="MySchedule"><i class="iconfa-th"></i> My Schedule</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Daily Production Schedule</h1>
        </div>
    </div><!--pageheader-->
		<div class="box box-primary">
			<div class="box-header">
				Production Schedule 
			</div>
			<div class="box-body">
			    <table class="table table-bordered table-invoice" style="float: left; margin-right: 1%; width: 49.5%;">
                    <tr>
                        <td class="width30">Schedule Incharge:</td>
                        <td class="width70"><strong>Abdur Rahim</strong></td>
                    </tr>
                    <tr>
                        <td>Duty Workers:</td>
                        <td><strong>Rahim (12012), Karim (56213), Farhad (25135)</strong></td>
                    </tr>
                    <tr>
                        <td>Start Time:</td>
                        <td><strong>April 30, 2015 at 12:00am TO 12:00pm</strong></td>
                     </tr>
                </table>
				
				<table class="table table-bordered table-invoice" style="width: 49.5%;">
                    <tr>
                        <td class="width30">Machin No:</td>
                        <td class="width70"><strong>02</strong></td>
                    </tr>
                    <tr>
                        <td>Production Speed:</td>
                        <td><strong>22</strong></td>
                    </tr>
                    <tr>
                        <td>Type of Production:</td>
                        <td><strong>Print & Non-Print</strong></td>
                     </tr>
                </table>
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">Clint ID</th>
                            <th class="head1">Clint Name</th>
							<th class="head0">Zone</th>
							<th class="head1">Order Quentity</th>
							<th class="head0">Estimated Time</th>
							<th class="head1">Start</th>
							<th class="head0 center">Out Quentity</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							$sql = mysql_query("SELECT z_id, z_name, z_bn_name FROM zone ORDER BY z_id asc");
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['z_id']}</td>
											<td>KFC a b c d e f g h i j k l m n o p q r s t</td>
											<td>Dhaka-1</td>
											<td>80</td>
											<td>2:45 Hours</td>
											<td><button class='btn' placeholder='' type='button'>Start!</button></td>
											<td><input type ='text' class='' style='width: 65%;' name='' id='' ><button class='btn' placeholder='' type='button'>Done!</button></td>
											<input type ='hidden' class='' name='c_id' id='' >
											<input type ='hidden' class='' name='time' id='' >
											<input type ='hidden' class='' name='date' id='' >
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='",$id,"{$row['z_id']}' data-original-title='Edit' class='btn col1'><i class='iconfa-edit'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>

				<table class="table table-bordered table-invoice" style="width: 49.5%;">
                    <tr>
                        <td class="width30">Total Non-Print Quentity</td>
                        <td class="width70"><input type ='text' class='' placeholder='EX: 5000'  style='width: 95%;' name='' id='' ></td>
                    </tr>
                    <tr>
                        <td>Incharge Remark:</td>
                        <td><strong><textarea type="text" name="" placeholder="Optional" id="" style='width: 95%;' rows="1" class="input-xxlarge" /></textarea></strong></td>
                    </tr>
                </table>
				<table class="table invoice-table" style="width: 45.5%; float: right; margin-top: -13%; margin-right: 5%;">
							<tbody>
								<tr>
									<td class="width65 msg-invoice">
										<h4></h4>
										<p></p>
									</td>
									<td class="width15 right numlist">
										<strong>Print</strong>
										<strong>Non-Print</strong>
										<strong>Total</strong>
									</td>
									<td class="width20 right numlist">
										<strong>5400</strong>
										<strong>4200</strong>
										<strong>9600</strong>
									</td>
								</tr>
							</tbody>
				 </table>
				 							</div>
								<div class="modal-footer">
									<button type="reset" class="btn">Reset</button>
									<button class="btn btn-primary" type="submit">Submit & End</button>
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
