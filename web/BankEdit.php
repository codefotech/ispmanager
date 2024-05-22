<?php
$titel = "Edit Back Information";
$Bank = 'active';
include('include/hader.php');
$id = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Bank' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

//$sql2 ="SELECT * FROM bank WHERE id = '$id'";
$sql2 ="SELECT b.id, b.bank_name, b.`sort_name`, b.`emp_id`, b.`show_exp`, b.`sts`, ifnull(p.online, '0') AS online, p.name FROM `bank` AS b LEFT JOIN payment_mathod AS p ON p.bank = b.id WHERE b.id = '$id'";

$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$b_id = $row2['id'];
$bank_name = $row2['bank_name'];
$sort_name = $row2['sort_name'];
$emp_id = $row2['emp_id'];
$online = $row2['online'];
$method_name = $row2['name'];

$query2f = mysql_query("SELECT id, name, note, online FROM payment_mathod WHERE bank = '$id' AND sts = '0' ORDER BY id ASC");
$vlancount = mysql_num_rows($query2f);

if($user_type == 'admin' || $user_type == 'superadmin'){
?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Bank"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Edit Bank</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Bank Information Edit</h5>
				</div>
				<form id="form" class="stdform" method="post" action="BankEditQuery" >
					<div class="modal-body">
					<p>
						<label>Bank ID</lab
						<span class="field">
							<div class="controls">	
								<input style="text-align:center;" id="" type="text" class="input-xxlarge" readonly name="b_id" value="<?php echo $b_id;?>">
							</div>
						</span>
					</p>
					<p>
						<label style="font-weight: bold;">Bank Name*</label>
						<span class="field"><input style="text-align:center;" id="" type="text" name="bank_name" class="input-xxlarge" value="<?php echo $bank_name;?>" required=""></span>
					</p>
					<p>
						<label style="font-weight: bold;">Bank Sort Name*</label>
						<span class="field"><input style="text-align:center;" id="" type="text" name="sort_name" class="input-xxlarge" value="<?php echo $sort_name;?>" required=""></span>
					</p>
					<?php if($emp_id != ''){ ?>
					<p>
						<label>Employee ID</label>
						<span class="field"><input style="text-align:center;" id="" readonly type="text" name="" class="input-xxlarge" value="<?php echo $emp_id;?>"></span>
					</p>
					<?php } if($emp_id == ''){ ?>
					<p>
						<label style="font-weight: bold;">Online Methods</label>
						<span class="field" style="margin-left: 0px;">
							<table class="table table-bordered responsive nnew5" style="max-width: 35%">
								<colgroup>
									<col class="con1" />
									<col class="con0" />
									<col class="con1" />	
									<col class="con0" />
								</colgroup>
								 <thead class="newThead">
												<tr>	
													<th style="width: 5%;text-align: center;"><input id="check_all5" class="case5" type="checkbox"/></th>
													<th style="width: 75%;text-align: center;">Name</th>
													<th style="width: 10%;text-align: center;">Active?</th>
												</tr>
								 </thead>
							 <tbody>
								
								<?php 
								if($vlancount > '0'){
								$vlandata = array();
								while($rowwww = mysql_fetch_assoc($query2f)) {
									$vlandata[] = $rowwww;
								}
								foreach($vlandata as $key=>$val) { ?>
								<tr class='gradeX'>
									<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input type="checkbox" class="case5"/><input type="hidden" name="mid[]" id="mid_<?php echo $key;?>" value="<?php echo $key;?>"/></td>
									<td class="center" style="width: 60%;border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" value="<?php echo $val['name'];?>" name="methodname[]" placeholder="Online Method Name" id="methodname_1" class="changesNoform-control autocomplete_txt" autocomplete="off" required=""></td>
									<td class="center" style="width: 10%;border-top: 1px solid #dddddd;">
										<input type="checkbox" name="online[]" id="online_1" value="1" <?php if ('1' == $val['online']) echo 'checked="checked"';?>>&nbsp;<b>Yes</b>
									</td>
								</tr>
								<?php }} else{ ?>
								<tr class='gradeX'>
									<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input class="case5" type="checkbox"/><input type="hidden" name="mid[]" id="mid_1" value="1"/></td>
									<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="methodname[]" placeholder="Online Method Name" id="methodname_1" class="changesNoform-control autocomplete_txt" autocomplete="off" required=""></td>
									<td class="center" style="width: 10%;border-top: 1px solid #dddddd;">
										<input type="checkbox" id="online_1" name="online[]" value="1">&nbsp;<b>Yes</b>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							</table>
						</span>
					</p>
					<p>
						<label></label>
						<span class="field" style="margin-left: 0px;">
							<button class="btn-danger delete5" style="font-size: 25px;" type="button"> - </button>
							<button class="btn-success addmore5" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
						</span>
					</p>
					<?php } ?>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn">Reset</button>
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>
				</form>			
			</div>
		</div>
	</div>
<?php
}}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script src="invoice/js/jquery.min.js"></script>
<script src="invoice/js/jquery-ui.min.js"></script>
<script src="invoice/js/auto_ClientEditMonthlyInvoice.js"></script>