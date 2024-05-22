<?php
$titel = "Payroll";
$BonusPayroll = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'BonusPayroll' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$query = "SELECT e_id, e_name FROM emp_info WHERE e_release_date = '0000-00-00' ORDER BY e_name";
$result = mysql_query($query);

?>
	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Bonus Payroll</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Bonus Payroll</h5>
				</div>
				
			<div class="modal-body">
				<form id="" name="form1" class="stdform" method="post" action="BonusPayrollSave">
					<input type="hidden" value="1" name="action" />
					<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="ent_by" />
					<input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="ent_date" />
						
						<p>
							<label>Employee</label>
							<select data-placeholder="Choose one" name="e_id" style="width:50%;" class="chzn-select" required="">
								<option value=""></option>
									<?php while ($row = mysql_fetch_array($result)) { ?>
								<option value="<?php echo $row['e_id'] ?>"><?php echo $row['e_id']?> - <?php echo $row['e_name']?></option>
									<?php } ?>
							</select>
						</p>
						<p>
							<label>Bonus Type</label>
							<select data-placeholder="Choose one" name="bonus_type" style="width:50%;" class="chzn-select" required="">
								<option value=""></option>
								<option value="1">Half</option>
								<option value="2">Quarter</option>
							</select>
						</p>
						<p>
							<label>Salary Date/Month</label>
							<span class="field"><input type="text" class="datepicker" name="bonus_date" required="" id="" style="width:30%;;" readonly value="<?php echo date('Y-m-d'); ?>" /></span>
						</p>
						<p>
							<label>Notes</label>
							<span class="field"><textarea type="text" name="note" style="width:61%;" id="" placeholder="Expanse Note (If Any)" class="input-xxlarge" /></textarea></span>
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
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
                            <th class="head0">S/L</th>
							<th class="head1">Date</th>
							<th class="head0">Employee</th>
							<th class="head1">Bonus Type</th>
							<th class="head0">Note</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$sqls = mysql_query("SELECT e.e_name, p.bonus_type, p.bonus_date, p.note 
													FROM employee_bonus AS p
													LEFT JOIN  emp_info AS e
													ON e.e_id = p.e_id
													ORDER BY p.id DESC LIMIT 10");
									$x = 1;
									while( $rows = mysql_fetch_assoc($sqls) ){
										
										$type = $rows['bonus_type'] == 1 ? 'Half' : 'Quarter';
										echo
											"<tr class='gradeX'>
												<td>{$x}</td>
												<td>{$rows['bonus_date']}</td>
												<td>{$rows['e_name']}</td>
												<td>{$type}</td>
												<td>{$rows['note']}</td>
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