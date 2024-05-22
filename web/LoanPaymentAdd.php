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
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Loan"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Loan Payment</h1>
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
					<h5>Add Loan Payment</h5>
				</div>
					<form id="form" class="stdform" method="post" action="LoanPaymentSave">
						<input type="hidden" value="<?php echo $e_id; ?>" name="entry_by" />
						<input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="enty_date" /> 
							<div class="modal-body">
								<p>	
									<label>Loan Payment To*</label>
									<select data-placeholder="Choose receiver" name="loan_payment_to" class="chzn-select"  style="width:50% !important;" required="">
										<option value=""></option>
													<?php while ($row1=mysql_fetch_array($LoanFrom)) { ?>
												<option value="<?php echo $row1['id'] ?>"><?php echo $row1['name']?></option>
													<?php } ?>
									</select>
								</p>
								<p>
									<label>Loan Amount*</label>
									<span class="field"><input type="text" name="amount" placeholder="Amount Of TK" required="" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Payment From*</label>
									<select data-placeholder="Select a Bank" name="bank" class="chzn-select"  style="width:50% !important;" required="">
										<option value=""></option>
													<?php while ($row=mysql_fetch_array($Bank)) { ?>
												<option value="<?php echo $row['id'] ?>"><?php echo $row['bank_name']?></option>
													<?php } ?>
									</select>
								</p>
								
								<p>
									<label>Payment Date</label>
									<span class="field"><input type="text" name="payment_date" readonly required="" id="" class="input-xxlarge datepicker" value="<?php echo date("Y-m-d");?>" /></span>
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
                             <h3 class="box-title">List of Loan Payment </h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                             <table class="table responsive table-bordered">
                                 <thead>
                                     <tr>
                                         <th>Id </th>
                                         <th>Date </th>
                                         <th>Payment To</th>
                                         <th>Payment From</th>
                                         <th>Amount </th>
                                         <th>Note </th>
                                     </tr>
                                 </thead>
                                 <tbody>
									<?php
										$sql = mysql_query("SELECT a.id, b.bank_name, t.name, a.amount, a.payment_date, a.note FROM loan_payment AS a
													LEFT JOIN loan_from AS t ON t.id = a.loan_payment_to
													LEFT JOIN bank AS b ON b.id = a.bank
													ORDER BY a.id DESC LIMIT 10");
										while( $row = mysql_fetch_assoc($sql) )
										{
											echo
												"<tr>
													<td>{$row['id']}</td>
													<td>{$row['payment_date']}</td>
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