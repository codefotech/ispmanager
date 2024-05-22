<?php
$titel = "Support Task";
$Support = 'active';
include('include/hader.php');
include("conn/connection.php");
extract($_POST);
ini_alter('date.timezone','Asia/Almaty');
$eid = $_SESSION['SESS_EMP_ID'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Support' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$queryddd=mysql_query("SELECT id, pro_name, pro_details FROM project WHERE sts = '0' ORDER BY pro_name ASC");

	$query1="SELECT dept_id, dept_name FROM department_info WHERE status = '0' ORDER BY dept_name ASC";
	$result1=mysql_query($query1);

	$query1dd="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' ORDER BY e_id ASC";
	$result1ass=mysql_query($query1dd);
	
	$query1ddc="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' ORDER BY e_id ASC";
	$result1assc=mysql_query($query1ddc);

if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}

$sql2 ="SELECT id FROM expanse ORDER BY id DESC LIMIT 1";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$idz = $row2['id'];
$voucher = $idz + 1;
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		</div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Task & Support</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add New Task</h5>
				</div>
				<div class="modal-body">
				<form id="" name="form1" class="stdform" method="post" action="ExpanseAddSave">
					<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="entry_by" />
					<input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" name="enty_date" />
						<p>
							<label>Task ID*</label>
							<span class="field"><input type="text" name="voucher" value="<?php echo 'TASK'.$voucher;?>" style="width:10%;" readonly required="" placeholder="Voucher No" /></span>
						</p>
						<p>
							<label>Task Name*</label>
							<span class="field"><input type="text" name="voucher" style="width:30%;" required="" placeholder="" /></span>
						</p>
						<p>
							<label>Project*</label>
							<span class="field">
								<select data-placeholder="Choose a Head" name="type" class="chzn-select"  style="width:20%;" required="">
									<option value=""></option>
										<?php while ($row=mysql_fetch_array($queryddd)) { ?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['pro_name']?></option>
										<?php } ?>
								</select>
								<select data-placeholder="Department" name="type" class="chzn-select"  style="width:20%;" required="">
								<option value=""></option>
									<?php while ($rowss=mysql_fetch_array($result1)) { ?>
								<option value="<?php echo $rowss['id'] ?>"><?php echo $rowss['dept_name']?></option>
									<?php } ?>
							</select>
							</span>
						</p>
						<p>
							<label>Assignee*</label>
							<span class="field">
								<select data-placeholder="Choose a Head" name="type" class="chzn-select"  style="width:20%;" required="">
										<option value=""></option>
									<?php while ($rowass=mysql_fetch_array($result1ass)) { ?>
										<option value="<?php echo $rowass['e_id'] ?>"><?php echo $rowass['e_id'];?> | <?php echo $rowass['e_name']; ?></option>
									<?php } ?>
								</select>
							</span>
						</p>
						<p>
							<label></label>
							<span class="field">
								<select data-placeholder="Collaborators" multiple="multiple" name="" style="width:40%;" class="chzn-select">
									<option value=""></option>
									<?php while ($rowassc=mysql_fetch_array($result1assc)) { ?>
										<option value="<?php echo $rowassc['e_id'] ?>"><?php echo $rowassc['e_id'];?> | <?php echo $rowassc['e_name']; ?></option>
									<?php } ?>
								</select>
							</span>
						</p>
						<p>	
							<label>Client</label>
							<span class="field">
							<select data-placeholder="Choose a Head" name="type" class="chzn-select"  style="width:20%;">
								<option value=""></option>
									<?php while ($row=mysql_fetch_array($result)) { ?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['ex_type']?></option>
									<?php } ?>
							</select>
							</span>
						</p>
						
						<p>
							<label>Due Date*</label>
							<span class="field">
								<div class="input-append bootstrap-timepicker">
									<input type="text" name="" id="" readonly style="width:40%;" class="datepicker" value="<?php echo date("Y-m-d");?>" required="" />
									<input id="" type="text" class="" style="width:30%;height: 20px;text-align: center;" value="<?php echo date("H:i:s");?>" /><span class="add-on" style="height: 20px;"><i class="iconfa-time"></i></span>
								</div>
							</span>
						</p>
						<p>
							<label>End Date*</label>
							<span class="field">
								<div class="input-append bootstrap-timepicker">
									<input type="text" name="" id="" readonly style="width:40%;" class="datepicker" value="<?php echo date("Y-m-d");?>" required="" />
									<input id="timepicker1" type="text" class="add-on" style="width:30%;height: 20px;" value="<?php echo date("H:i:s");?>" /><span class="add-on" style="height: 20px;"><i class="iconfa-time"></i></span>
								</div>
							</span>
						</p>
						<p>
							<label>Priority*</label>
							<span class="field">
								<select class="chzn-select" name="priority" style="width:20%;" required="" onChange="getRoutePoint1(this.value)"> 
									<option value="urgent">Urgent</option>
									<option value="high">High</option>
									<option value="medium">Medium</option>
									<option value="low">Low</option>
								</select>
							</span>
						</p>
						<p>
							<label>Description*</label>
							<span class="field"><textarea type="text" name="note" style="width:40%;" id="" placeholder="Expense Note (If Any)" class="input-xxlarge" /></textarea></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
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

                            <th class="head1">Voucher No</th>
                            <th class="head0">Date</th>
							<th class="head1">Expense For</th>
							<th class="head0">Type</th>
							<th class="head1">Bank</th>
							<th class="head1">Amount</th>
							<th class="head0">Note</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$sql = mysql_query("SELECT e.id, e.voucher, b.sort_name, e.exp_for, e.ex_date, t.ex_type, e.amount, e.enty_date, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN bank AS b	ON b.id = e.bank
													WHERE e.entry_by = '$eid' AND e.status = '0'
													ORDER BY e.id DESC LIMIT 10");
									while( $row = mysql_fetch_assoc($sql) )
									{
										echo
											"<tr class='gradeX'>
												<td>{$row['voucher']}</td>
												<td>{$row['ex_date']}</td>
												<td>{$row['exp_for']}</td>
												<td>{$row['ex_type']}</td>
												<td>{$row['sort_name']}</td>
												<td>{$row['amount']}</td>
												<td>{$row['note']}</td>
											</tr>\n";
									}  
							?>
                    </tbody>
            </table>
		</div>
	</div>
	<?php
}
else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php }
include('include/footer.php');
?>
