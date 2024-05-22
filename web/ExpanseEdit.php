<?php
$titel = "Expense";
$Expanse = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);

$eid = $_SESSION['SESS_EMP_ID'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Expanse' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '41' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------
if(in_array(252, $access_arry)){
$sqlkkk = mysql_query("SELECT e.id, b.sort_name, e.mathod, e.category, e.v_id, e.type, e.ck_trx_no, b.id AS bank_id, e.check_by, z.dept_name AS ckdept_name, q.e_name AS checkby, DATE_FORMAT(e.check_date, '%D %M %Y %h:%i%p') AS check_date, e.check_note, b.bank_name, e.voucher, e.ex_date, a.e_name, a.e_id, e.ex_by, t.ex_type, d.dept_name, a.e_cont_per, e.amount, DATE_FORMAT(e.enty_date, '%D %M %Y %h:%i%p') AS enty_date, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN emp_info AS a	ON a.e_id = e.ex_by
													LEFT JOIN bank AS b	ON b.id = e.bank
													LEFT JOIN department_info AS d ON d.dept_id = a.dept_id 
													LEFT JOIN emp_info AS q	ON q.e_id = e.check_by
													LEFT JOIN department_info AS z ON z.dept_id = q.dept_id 
													WHERE e.id = '$exid' AND e.status = '0'");
$ressss=mysql_fetch_assoc($sqlkkk);
}
else{
$sqlkkk = mysql_query("SELECT e.id, b.sort_name, e.category, e.v_id, e.mathod, e.type, e.ck_trx_no, b.id AS bank_id, e.check_by, z.dept_name AS ckdept_name, q.e_name AS checkby, DATE_FORMAT(e.check_date, '%D %M %Y %h:%i%p') AS check_date, e.check_note, b.bank_name, e.voucher, e.ex_date, a.e_name, a.e_id, e.ex_by, t.ex_type, d.dept_name, a.e_cont_per, e.amount, DATE_FORMAT(e.enty_date, '%D %M %Y %h:%i%p') AS enty_date, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN emp_info AS a	ON a.e_id = e.ex_by
													LEFT JOIN bank AS b	ON b.id = e.bank
													LEFT JOIN department_info AS d ON d.dept_id = a.dept_id 
													LEFT JOIN emp_info AS q	ON q.e_id = e.check_by
													LEFT JOIN department_info AS z ON z.dept_id = q.dept_id 
													WHERE e.id = '$exid' AND e.ex_by = '$eid' AND e.status = '0'");
$ressss=mysql_fetch_assoc($sqlkkk);
}

$query="SELECT id, ex_type FROM expanse_type WHERE status = '0' ORDER BY ex_type ASC";
$result=mysql_query($query);

if(in_array(254, $access_arry)){
	$query1="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' ORDER BY e_id ASC";
	$result1=mysql_query($query1);
}
else{
	$query1="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' AND e_id = '$e_id' ORDER BY e_id ASC";
	$result1=mysql_query($query1);
}

if(in_array(255, $access_arry)){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}

$vendorrr = mysql_query("SELECT id, v_name, cell, location FROM vendor WHERE sts = 0 ORDER BY v_name");
?>

	<div class="pageheader">
        <div class="searchbar">
			
		</div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Edit Expense</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Expense</h5>
				</div>
					<div class="modal-body">
				<form id="" name="form1" class="stdform" method="post" action="ExpanseEditSave">
					<input type="hidden" value="<?php echo $exid; ?>" name="exid" />
					<input type="hidden" value="<?php echo $eid; ?>" name="edit_by" />
					<input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" name="edit_time " />
						<p>
							<label>Voucher No*</label>
							<span class="field"><input type="text" name="voucher" id="" value="<?php echo $ressss['voucher']; ?>" style="width:15%;" required="" placeholder="Voucher No" /></span>
						</p>
						<?php if($ressss['category'] == '1'){?>
						<p>	
							<label>Vendor*</label>
							<select data-placeholder="Choose Send By" name="v_id" class="chzn-select"  style="width:30% !important;" required="">
								<option value="">Choose Vendor</option>
									<?php while ($row1=mysql_fetch_array($vendorrr)) {?>
								<option value="<?php echo $row1['id']; ?>"<?php if($row1['id'] == $ressss['v_id']) echo 'selected="selected"';?>><?php echo $row1['v_name'];?> (<?php echo $row1['cell']; ?>) <?php echo $row1['location']; ?></option>
									<?php } ?>
							</select>
						</p>

						<?php } else{?>
						
						<?php }?>
						<p>
							<label>Responsible*</label>
							<select data-placeholder="Type Of Expense" name="exp_by" style="width:30%;" class="chzn-select" required="">
								<option value=""></option>
									<?php while ($row=mysql_fetch_array($result1)) { ?>
								<option value="<?php echo $row['e_id']; ?>"<?php if ($row['e_id'] == $ressss['ex_by']) echo 'selected="selected"';?>><?php echo $row['e_name'];?> - <?php echo $row['e_des'];?> - <?php echo $row['e_id'];?></option>
									<?php } ?>
							</select>
						</p>
						<p>	
							<label>Expense Type/Head*</label>
							<select data-placeholder="Choose a Head" name="type" class="chzn-select"  style="width:30%;" required="">
								<option value=""></option>
									<?php while ($row=mysql_fetch_array($result)) { ?>
								<option value="<?php echo $row['id']; ?>"<?php if ($row['id'] == $ressss['type']) echo 'selected="selected"';?>><?php echo $row['ex_type'];?></option>
									<?php } ?>
							</select>
						</p>
						<p>
							<label>Bank*</label>
							<select data-placeholder="Type Of bank" name="bank" style="width:30%;" class="chzn-select" required="">
								<option value=""></option>
								<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>
									<option value="<?php echo $rowBank['id']; ?>"<?php if ($rowBank['id'] == $ressss['bank_id']) echo 'selected="selected"';?>><?php echo $rowBank['bank_name'];?> <?php echo $rowBank['emp_id']; ?></option>
								<?php } ?>
							</select>
						</p>
						<p>
							<label>Expense Amount*</label>
							<span class="field"><input type="text" name="amount" id="" style="width:10%;" required=""  value="<?php echo $ressss['amount']; ?>" placeholder=" Amount Of TK" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
						</p>
						<p>
						<label>Mathod</label>
							<span class="field">
								<select class="chzn-select" name="mathod" style="width:280px;" required="" onChange="getRoutePoint(this.value)"> 
											<option  value="Cash" <?php if ('Cash' == $ressss['mathod']) echo 'selected="selected"';?>>CASH</option>
											<option  value="Bank" <?php if ('Bank' == $ressss['mathod']) echo 'selected="selected"';?>>BANK</option>
											<option  value="Online" <?php if ('Online' == $ressss['mathod']) echo 'selected="selected"';?>>ONLINE</option>
								</select>
							</span>
								</p><div id="Pointdiv">
								<?php if($ressss['mathod'] == 'Bank' || $ressss['mathod'] == 'Online'){?>
								<p>
								<label>Check/Trx No</label>
									<span class="field"><input type="text" name="ck_trx_no" class="input-xlarge" required="" value="<?php echo $ressss['ck_trx_no'];?>"/></span>
								</p>
								<?php } ?>
								</div>
						<p>
							<label>Note</label>
							<span class="field"><textarea type="text" name="note" style="width:40%;" id="" placeholder="Expense Note (If Any)" class="input-xxlarge" /><?php echo $ressss['note']; ?></textarea></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>			
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
<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	

	function getRoutePoint(afdId) {		
		
		var strURL="ex_mathod.php?mathod="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>