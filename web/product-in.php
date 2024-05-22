<?php 
session_start(); // NEVER FORGET TO START THE SESSION!!!
$user_type = $_SESSION['SESS_USER_TYPE'];
$eee_id = $_SESSION['SESS_EMP_ID'];
$v_billadd=$_GET['v_billadd'];
$exp_add=$_GET['exp_add'];
include("conn/connection.php");

if($v_billadd == 'Yes'){ 

$queryww="SELECT id, ex_type FROM expanse_type WHERE status = '0' AND id != '1' AND id != '2' ORDER BY ex_type ASC";
$resultww=mysql_query($queryww);
?>
<table class="table table-bordered table-invoice">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">Bill Purpose*</td>
											<td class="width70">
												<select data-placeholder="Choose a Head" name="v_purpose" style="font-weight: bold;" required="">
													<option value=""></option>
														<?php while ($rowee=mysql_fetch_array($resultww)) { ?>
													<option value="<?php echo $rowee['id'] ?>"><?php echo $rowee['ex_type']?></option>
														<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Bill Type</td>
											<td>
												<select style="font-weight: bold;" name="v_bill_type" required=""> 
													<option value="OneTime">One Time</option>
												</select>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Bill Amount*</td>
											<td>
												<input type="text" style="width: 30%;text-align: center;font-size: 20px;font-weight: bolder;color: orangered;" name="v_amount" id="v_totalAftertax"  placeholder="" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required=""><input type="text" style="width: 18px;font-weight: bold;font-size: 20px;border-radius: 0px 5px 5px 0px;border-left: 0;color: #58666e;" readonly value="৳"/>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Vendor Bill Note</td>
											<td>
												<textarea type="text" name="v_note" id="" style="width: 90%;" placeholder="Bill Note (If Any)" /></textarea>
											</td>
										</tr>
									</table>
<?php }else{ } 

if($exp_add == 'Yes'){ 
if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = '0' ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = '0' AND emp_id = '$eee_id' ORDER BY bank_name");
}

$queryexx="SELECT id, ex_type FROM expanse_type WHERE status = '0' AND id != '1' AND id != '2' ORDER BY ex_type ASC";
$resultexx=mysql_query($queryexx);
?>
<table class="table table-bordered table-invoice">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">Purpose & Bank*</td>
											<td class="width70">
												<select placeholder="Choose a Head" name="e_type" style="width: 48%;font-weight: bold;" required="">
													<option value=""></option>
														<?php while ($roweess=mysql_fetch_array($resultexx)) { ?>
													<option value="<?php echo $roweess['id'] ?>"><?php echo $roweess['ex_type']?></option>
														<?php } ?>
												</select>
												<select data-placeholder="Type Of bank" name="e_bank" required="" style="width: 48%;float: right;font-weight: bold;">
													<option value=""></option>
													<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>
														<option value="<?php echo $rowBank['id'] ?>"><?php echo $rowBank['bank_name'];?> (<?php echo $rowBank['emp_id']; ?>)</option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Payment Mathod</td>
											<td>
												<select class="chzn-select" name="e_mathod" style="width:30%;float: left;font-weight: bold;" required="" onChange="getRoutePoint(this.value)"> 
													<option value="Cash">CASH</option>
													<option value="Bank">BANK</option>
													<option value="Online">ONLINE</option>
												</select>
												<div id="Pointdiv" style="float: right;"></div>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Expense Amount*</td>
											<td>
												<input type="text" style="width: 30%;text-align: center;font-size: 20px;font-weight: bolder;color: #188e00;" name="e_amount" id="e_totalAftertax" placeholder="" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required=""><input type="text" style="width: 18px;font-weight: bold;font-size: 20px;border-radius: 0px 5px 5px 0px;border-left: 0;color: #58666e;" readonly value="৳"/>
												<select class="chzn-select" name="e_status" style="width: 48%;float: right;font-size: 15px;font-weight: bold;color: #8b00ff;" required=""> 
													<option value="2" style="color: #1d722c;">Approved</option>
													<option value="0" style="color: #1f72b4;">Pending</option>
												</select>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Expense Note</td>
											<td>
												<textarea type="text" name="e_note" id="" style="width: 90%;" placeholder="Expense Note (If Any)" /></textarea>
											</td>
										</tr>
									</table>
<?php }else{ } ?>