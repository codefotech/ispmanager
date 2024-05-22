<?php
$titel = "Loan";
$Loan = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Loan' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
$LoanFrom = mysql_query("SELECT * FROM loan_from WHERE sts = 0 ORDER BY name");

?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">

	<form id="form2" class="stdform" method="post" action="LoanFromSave">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Lone From Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Name:</div>
						<div class="col-2"><input type="text" name="loan_name" id="" placeholder="Ex: Full Name" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Address:</div>
						<div class="col-2"><input type="text" name="address" id="" placeholder="Ex: Address" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Cell:</div>
						<div class="col-2"><input type="text" name="cell" id="" placeholder="Ex: 01712345678" class="input-large" required=""/></div>
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
			<a class="btn btn-primary" href="Loan"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Loan Receive</h1>
        </div>
    </div><!--pageheader-->
	<?php if ($stat == 'done'){?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			 <strong>Successfully!!</strong> Your data successfully Inserted In Your Database.
		</div>
	<?php } ?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Loan Receive</h5>
				</div>
					<form id="form" class="stdform" method="post" action="LoanReceiveSave">
						<input type="hidden" value="<?php echo $e_id; ?>" name="entry_by" />
						<input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="enty_date" /> 
							<div class="modal-body">
								<p>	
									<label>Loan From*</label>
									<select data-placeholder="Choose receiver" name="loan_from" class="chzn-select"  style="width:45% !important;" required="">
										<option value=""></option>
													<?php while ($row1=mysql_fetch_array($LoanFrom)) { ?>
												<option value="<?php echo $row1['id'] ?>"><?php echo $row1['name']?></option>
													<?php } ?>
									</select>
									<button class="btn" style="height: 34px; margin-top: -27px;" href="#myModal" data-toggle="modal"> Add</button>
								</p>
								<p>
									<label>Loan Amount*</label>
									<span class="field"><input type="text" name="amount" placeholder="Amount Of TK" required="" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Receive To*</label>
									<select data-placeholder="Select a Bank" name="bank" class="chzn-select"  style="width:50% !important;" required="">
										<option value=""></option>
													<?php while ($row=mysql_fetch_array($Bank)) { ?>
												<option value="<?php echo $row['id'] ?>"><?php echo $row['bank_name']?></option>
													<?php } ?>
									</select>
								</p>
								
								<p>
									<label>Loan Date</label>
									<span class="field"><input type="text" name="loan_date" readonly required="" id="" class="input-xxlarge datepicker" value="<?php echo date("Y-m-d");?>" /></span>
								</p>
								<p>
									<label>Note</label>
									<span class="field"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xxlarge" /></textarea></span>
								</p>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
					</form>			
			</div>
		</div>
	</div>
	<div class="box">
                         <div class="box-header">
                             <h3 class="box-title">List of Loan Receive </h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                             <table class="table responsive table-bordered">
                                 <thead>
                                     <tr>
                                         <th>ID </th>
                                         <th>Date </th>
                                         <th>Loan From</th>
                                         <th>Receive To</th>
                                         <th>Amount </th>
                                         <th>Note </th>
                                     </tr>
                                 </thead>
                                 <tbody>
									<?php
										$sql = mysql_query("SELECT a.id, b.bank_name, t.name, a.amount, a.loan_date, a.note FROM loan_receive AS a
													LEFT JOIN loan_from AS t ON t.id = a.loan_from
													LEFT JOIN bank AS b ON b.id = a.bank
													ORDER BY a.id DESC LIMIT 10");
										while( $row = mysql_fetch_assoc($sql) )
										{
											echo
												"<tr>
													<td>{$row['id']}</td>
													<td>{$row['loan_date']}</td>
													<td>{$row['name']}</td>
													<td>{$row['bank_name']}</td>
													<td><a href='#'>{$row['amount']}</a></td>
													<td>{$row['note']}</td>
												</tr>";
										}  
									?>
                                 </tbody>
                             </table>
                         </div>
                         <!-- /.box-body -->
                     </div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>