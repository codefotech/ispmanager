<?php
$titel = "Salary Payment";
$Salary = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Salary' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$result = mysql_query("SELECT e_id, e_name FROM emp_info WHERE e_release_date = '0000-00-00' ORDER BY e_name");
$result1 = mysql_query("SELECT * FROM bank WHERE sts = 0 AND id = 122 ORDER BY bank_name");

$result = mysql_query("SELECT e.id, e.e_id, e.e_name, e.e_des, e.e_cont_per, d.dept_name, e.e_j_date, e.e_cont_office, e.gross_total, e.status, e.z_id FROM emp_info AS e
LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE e.status = '0' AND e.z_id = '' ORDER BY e.e_name ASC");

?>
	<div class="pageheader">
        <div class="searchbar">
			<button class="btn btn-primary" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i> Add New</button>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Salary Payment</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Salary Payment</h5>
				</div>
				
			<div class="modal-body">
				<form id="" name="form1" class="stdform" method="post" action="SalaryPaymentSave">
					<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="entry_by" />
					<input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="enty_date" />
						
						<p>
							<label>Salary Payment To</label>
							<select data-placeholder="Payment To...." name="payment_to" style="width:50%;" required="" class="chzn-select" required="">
								<option value=""></option>
									<?php while ($row=mysql_fetch_array($result)) { ?>
								<option value="<?php echo $row['e_id'] ?>"><?php echo $row['e_id']?> - <?php echo $row['e_name']?></option>
									<?php } ?>
							</select>
						</p>
						<p>
							<label>Amount</label>
							<span class="field"><input type="text" name="other_bonus" id="" style="width:10%;" placeholder="(if any)" onkeypress="return isNumberKey6(event)" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='Taka' readonly /></span>
						</p>
						<p>
							<label>Provident Fund</label>
							<span class="field"><input type="text" name="pf" id="" style="width:55%;" required="" placeholder=" Amount Of TK" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='TK' readonly /></span>
						</p>
						<p>
							<label>Payment From</label>
							<select data-placeholder="Payment From...." name="bank" style="width:50%;" required="" class="chzn-select" required="">
									<?php while ($row1=mysql_fetch_array($result1)) { ?>
								<option value="<?php echo $row1['id'] ?>"><?php echo $row1['bank_name']; ?></option>
									<?php } ?>
							</select>
						</p>
						<p>
							<label>Payment Date</label>
							<span class="field"><input type="text" class="" name="payment_date" required="" id="" style="width:30%;;" readonly value="<?php echo date("Y-m-d"); ?>" /></span>
						</p><!-- datepicker -->
						<p>
							<label>Notes</label>
							<span class="field"><textarea type="text" name="note" style="width:61%;" id="" placeholder="Payment Note (If Any)" class="input-xxlarge" /></textarea></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn">Reset</button>
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>
				</form>			
			</div>
		</div>
		<div class="box-body">
			<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
                            <th class="head1">S/L</th>
                            <th class="head0">Payment Date</th>
							<th class="head1">Payment To</th>
							<th class="head0">Payment From</th>
							<th class="head1">Payment Amount</th>
							<th class="head0">Note</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$sql = mysql_query("SELECT a.id, b.bank_name, e.e_name, a.amount, a.payment_date, a.note FROM emp_salary_payment AS a
													LEFT JOIN emp_info AS e ON e.e_id = a.payment_to
													LEFT JOIN bank AS b ON b.id = a.bank
													ORDER BY a.id DESC LIMIT 10");
									$x = 1;
									while( $row = mysql_fetch_assoc($sql) )
									{
										echo
											"<tr class='gradeX'>
												<td>{$row['id']}</td>
												<td>{$row['payment_date']}</td>
												<td>{$row['e_name']}</td>
												<td>{$row['bank_name']}</td>
												<td>{$row['amount']}</td>
												<td>{$row['note']}</td>
											</tr>\n ";
										$x++;
									}  
							?>
                    </tbody>
            </table>
		</div>
	</div>
	<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script>
<style>
#dyntable_length{display: none;}
#dyntable_filter{display: none;}
</style>