<?php
$titel = "Bill Adjustment";
$Billing = 'active';
include('include/hader.php');
extract($_POST);
	
$e_id = $_SESSION['SESS_EMP_ID'];
$user_type = $_SESSION['SESS_USER_TYPE'];
ini_alter('date.timezone','Asia/Almaty');
$update_date = date('Y-m-d', time());
$todayyy = date('01-m-Y', time());
$update_time = date('H:i:s', time());
$bill_date_yr = date('F, y', time());

$que = mysql_query("SELECT c_id, c_name, cell, address, con_sts, breseller, mac_user FROM clients WHERE c_id = '$c_id'");
$row = mysql_fetch_assoc($que);
$con_sts = $row['con_sts'];		
$breseller = $row['breseller'];		
$mac_user = $row['mac_user'];		

if($breseller == '1'){
$ques = mysql_query("SELECT b.id, b.c_id, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, b.day, c.discount as cdis, b.bill_date, b.p_price as bp_price, b.discount, b.bill_amount, c.total_bandwidth, c.total_price FROM billing AS b
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$c_id' ORDER BY b.bill_date DESC LIMIT 1");
$roww = mysql_fetch_assoc($ques);
$idq = $roww['id'];
$cl_id = $roww['c_id'];
$c_name = $roww['c_name'];
$bill_date = $roww['bill_date'];
$p_name = $roww['total_bandwidth'].' mb';
$bandwith = $roww['total_price'].' tk';
$p_price = $roww['total_price'];
$discount = $roww['discount'];
$bill_amount = $roww['bill_amount'];
$c_dis = $roww['cdis'];
$payment_deadline = $roww['payment_deadline'];
$macuser = $roww['mac_user'];
$bp_price = $roww['bp_price'];
$day = $roww['day'];
$mk_id = $roww['mk_id'];
}
elseif($breseller == '2'){
$ques = mysql_query("SELECT `id`, `invoice_id`, invoice_date, `c_id`, `item_id`, `item_name`, `description`, `quantity`, `unit`, `uniteprice`, `vat`, DATE_FORMAT(start_date, '%d-%m-%Y') AS start_date, DATE_FORMAT(end_date, '%d-%m-%Y') AS end_date, `days`, `total_price`, `due_deadline` FROM `billing_invoice` WHERE MONTH(invoice_date) = MONTH('$update_date') AND YEAR(invoice_date) = YEAR('$update_date') AND c_id = '$c_id' AND sts = '0'");

$quesdd = mysql_query("SELECT id, invoice_id, DATE_FORMAT(invoice_date, '%M-%Y') AS invoicedate, invoice_date, DATE_FORMAT(due_deadline, '%d-%m-%Y') AS due_deadline, DATE_FORMAT(due_deadline, '%d') AS payment_deadline FROM billing_invoice WHERE MONTH(invoice_date) = MONTH('$update_date') AND YEAR(invoice_date) = YEAR('$update_date') AND c_id = '$c_id' AND sts = '0' ORDER BY id ASC LIMIT 1");
$rowwdd = mysql_fetch_assoc($quesdd);
$invoice_id = $rowwdd['invoice_id'];
$invoice_date = $rowwdd['invoice_date'];
$invoicedate = $rowwdd['invoicedate'];
$due_deadline = $rowwdd['due_deadline'];
$payment_deadline = $rowwdd['payment_deadline'];

$idq = 'no';
}
else{
	if($mac_user == '0'){
$ques = mysql_query("SELECT b.id, b.c_id, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, b.day, c.discount as cdis, b.bill_date, b.p_price as bp_price, b.p_id, p.p_name, p.bandwith, p.p_price, b.discount, b.bill_amount FROM billing AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$c_id' ORDER BY b.bill_date DESC LIMIT 1");
$roww = mysql_fetch_assoc($ques);
$idq = $roww['id'];
$cl_id = $roww['c_id'];
$c_name = $roww['c_name'];
$bill_date = $roww['bill_date'];
$p_id = $roww['p_id'];
$p_name = $roww['p_name'];
$bandwith = $roww['bandwith'];
$p_price = $roww['p_price'];
$discount = $roww['discount'];
$bill_amount = $roww['bill_amount'];
$c_dis = $roww['cdis'];
$payment_deadline = $roww['payment_deadline'];
$macuser = $roww['mac_user'];
$bp_price = $roww['bp_price'];
$day = $roww['day'];
$mk_id = $roww['mk_id'];
	}
	else{
		$ques = mysql_query("SELECT b.id, b.c_id, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, b.day, c.discount as cdis, b.bill_date, b.p_price as bp_price, b.p_id, p.p_name, p.bandwith, p.p_price_reseller, b.discount, b.bill_amount FROM billing_mac_client AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$c_id' ORDER BY b.bill_date DESC LIMIT 1");
$roww = mysql_fetch_assoc($ques);
$idq = $roww['id'];
$cl_id = $roww['c_id'];
$c_name = $roww['c_name'];
$bill_date = $roww['bill_date'];
$p_id = $roww['p_id'];
$p_name = $roww['p_name'];
$bandwith = $roww['bandwith'];
$p_price = $roww['p_price'];
$discount = $roww['discount'];
$bill_amount = $roww['bill_amount'];
$c_dis = $roww['cdis'];
$payment_deadline = $roww['payment_deadline'];
$macuser = $roww['mac_user'];
$bp_price = $roww['bp_price'];
$day = $roww['day'];
$mk_id = $roww['mk_id'];
	}
}

if($idq != ''){
?>

	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>[<?php echo $bill_date_yr;?>] Bill Adjustment</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Bill Adjastment</h5>
				</div>
				<?php if($breseller != '2'){?>
				<form id="" name="form1" class="stdform" method="post" action="ClientsBillAdjustQuery" onsubmit='disableButton()'>
				<input type="hidden" name="idqqqw" value="<?php echo $idq;?>">
				<input type="hidden" name="c_id" value="<?php echo $c_id;?>">
				<input type="hidden" name="macuser" value="<?php echo $macuser;?>" />
				<input type="hidden" name="ee_id" value="<?php echo $e_id;?>">
				<input type="hidden" name="old_bill_amount" value="<?php echo $bill_amount;?>">
				<input type="hidden" name="breseller" value="<?php echo $breseller;?>">
					<div class="modal-body">
						<p>	
							<label>Client Info</label>
							<span class="field" style="font-size: 20px;line-height: 30px;">
								<b><?php echo $cl_id;?> |</b> <b><?php echo $p_name;?> |</b><b> <?php echo $p_price.' ৳';?></b>
							</span>
						</p>
						<p>
							<label>Generated Bill Date</label>
							<span class="field" style="font-size: 16px;line-height: 30px;"><b><?php echo date('jS M, Y');?></b></span>
						</p>
					<?php if(in_array(132, $access_arry)){?>
						<p>
							<label style="font-weight: bold;">Adjust [<?php echo $bill_date_yr;?>] Bill*</label>
							<span class="field"><input type="text" name="bill_amount" id="" style="width:100px;font-size: 20px;font-weight: bold;color: brown;" value="<?php echo $bill_amount;?>" required="" /><input type="text" name="" id="" style="width:17px; color:brown; font-weight: bold;font-size: 20px;border-left: none;" value='৳' readonly /></span>
						</p>
					<?php } else{ ?>
						<p>
							<label style="font-weight: bold;">Adjust [<?php echo $bill_date_yr;?>] Bill*</label>
							<span class="field"><input type="text" style="width:100px;font-size: 20px;font-weight: bold;color: brown;" id="" readonly style="width:100px;" value="<?php echo $bill_amount;?>" required="" /><input type="text" name="" id="" style="width:17px; color:brown; font-weight: bold;font-size: 20px;border-left: none;" value='৳' readonly /></span>
						</p>
					<?php } ?>
						<p>
							<label>Payment Deadline</label>
					<?php if(in_array(120, $access_arry)){?>
							<span class="field">
							<select class="chzn-select" name="payment_deadline" style="width: 80px;" />
								<option value="" <?php if('' == $payment_deadline) echo 'selected="selected"';?>>NO</option>
								<option value="01" <?php if('01' == $payment_deadline) echo 'selected="selected"';?>>01</option>
								<option value="02" <?php if('02' == $payment_deadline) echo 'selected="selected"';?>>02</option>
								<option value="03" <?php if('03' == $payment_deadline) echo 'selected="selected"';?>>03</option>
								<option value="04" <?php if('04' == $payment_deadline) echo 'selected="selected"';?>>04</option>
								<option value="05" <?php if('05' == $payment_deadline) echo 'selected="selected"';?>>05</option>
								<option value="06" <?php if('06' == $payment_deadline) echo 'selected="selected"';?>>06</option>
								<option value="07" <?php if('07' == $payment_deadline) echo 'selected="selected"';?>>07</option>
								<option value="08" <?php if('08' == $payment_deadline) echo 'selected="selected"';?>>08</option>
								<option value="09" <?php if('09' == $payment_deadline) echo 'selected="selected"';?>>09</option>
								<option value="10" <?php if('10' == $payment_deadline) echo 'selected="selected"';?>>10</option>
								<option value="11" <?php if('11' == $payment_deadline) echo 'selected="selected"';?>>11</option>
								<option value="12" <?php if('12' == $payment_deadline) echo 'selected="selected"';?>>12</option>
								<option value="13" <?php if('13' == $payment_deadline) echo 'selected="selected"';?>>13</option>
								<option value="14" <?php if('14' == $payment_deadline) echo 'selected="selected"';?>>14</option>
								<option value="15" <?php if('15' == $payment_deadline) echo 'selected="selected"';?>>15</option>
								<option value="16" <?php if('16' == $payment_deadline) echo 'selected="selected"';?>>16</option>
								<option value="17" <?php if('17' == $payment_deadline) echo 'selected="selected"';?>>17</option>
								<option value="18" <?php if('18' == $payment_deadline) echo 'selected="selected"';?>>18</option>
								<option value="19" <?php if('19' == $payment_deadline) echo 'selected="selected"';?>>19</option>
								<option value="20" <?php if('20' == $payment_deadline) echo 'selected="selected"';?>>20</option>
								<option value="21" <?php if('21' == $payment_deadline) echo 'selected="selected"';?>>21</option>
								<option value="22" <?php if('22' == $payment_deadline) echo 'selected="selected"';?>>22</option>
								<option value="23" <?php if('23' == $payment_deadline) echo 'selected="selected"';?>>23</option>
								<option value="24" <?php if('24' == $payment_deadline) echo 'selected="selected"';?>>24</option>
								<option value="25" <?php if('25' == $payment_deadline) echo 'selected="selected"';?>>25</option>
								<option value="26" <?php if('26' == $payment_deadline) echo 'selected="selected"';?>>26</option>
								<option value="27" <?php if('27' == $payment_deadline) echo 'selected="selected"';?>>27</option>
								<option value="28" <?php if('28' == $payment_deadline) echo 'selected="selected"';?>>28</option>
								<option value="29" <?php if('29' == $payment_deadline) echo 'selected="selected"';?>>29</option>
								<option value="30" <?php if('30' == $payment_deadline) echo 'selected="selected"';?>>30</option>
								<option value="31" <?php if('31' == $payment_deadline) echo 'selected="selected"';?>>31</option>
							</select>
					<?php } else{ ?>
							<span class="field"><input type="text" name="payment_deadline" placeholder="Date in every month like: 07" id="" readonly class="input-xlarge" value="<?php echo $payment_deadline;?>">
					<?php } ?>
							<br /><a style= "color:red;font-weight: bold;"> Note: When you submit this form, this tab will be close automatically.</a></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit" id="submitdisabl">Submit</button>
					</div>
				</form>	
				<?php } else{?>		
				<form id="" name="form1" class="stdform" method="post" action="ClientsBillAdjustQuery" onsubmit='disableButton()'>
				<input type="hidden" name="idqqqw" value="<?php echo $idq;?>">
				<input type="hidden" name="c_id" value="<?php echo $c_id;?>">
				<input type="hidden" name="ee_id" value="<?php echo $e_id;?>">
				<input type="hidden" name="breseller" value="<?php echo $breseller;?>">
				<input type="hidden" name="invoice_id" value="<?php echo $invoice_id;?>">
				<input type="hidden" name="invoice_date" value="<?php echo $invoice_date;?>">
				<div class="modal-body">
				<div class="row" style="padding: 0px 15px 20px 30px;">
						<div style="padding-left: 15px; width: 100%;">
							<table class="table table-bordered table-invoice" style="width: 45%; float: left;">
								<tr>
									<td class="width30">Client ID</td>
									<td class="width70"><strong><?php echo $row['c_name'].' ('.$row['c_id'].')';?></strong></td>
								</tr>
								<tr>
									<td>Contact No</td>
									<td><?php echo $row['cell'];?></td>
								</tr>
								<tr>
									<td>Address</td>
									<td><?php echo $row['address'];?></td>
								</tr>
							</table>
							<table class="table table-bordered table-invoice" style="width: 45%; float: left; margin-left: 7%;">
								<tr>
									<td class="width30">Invoice No</td>
									<td class="width70"><strong><?php echo $invoice_id;?></strong></td>
								</tr>
								<tr>
									<td>Billing Month</td>
									<td><?php echo $invoicedate;?></td>
								</tr>
								<tr>
									<td>Due Deadline</td>
									<td>
										<select class="chzn-select" name="due_deadline" style="width: 80px;" />
											<option value="" <?php if('' == $payment_deadline) echo 'selected="selected"';?>>NO</option>
											<option value="01" <?php if('01' == $payment_deadline) echo 'selected="selected"';?>>01</option>
											<option value="02" <?php if('02' == $payment_deadline) echo 'selected="selected"';?>>02</option>
											<option value="03" <?php if('03' == $payment_deadline) echo 'selected="selected"';?>>03</option>
											<option value="04" <?php if('04' == $payment_deadline) echo 'selected="selected"';?>>04</option>
											<option value="05" <?php if('05' == $payment_deadline) echo 'selected="selected"';?>>05</option>
											<option value="06" <?php if('06' == $payment_deadline) echo 'selected="selected"';?>>06</option>
											<option value="07" <?php if('07' == $payment_deadline) echo 'selected="selected"';?>>07</option>
											<option value="08" <?php if('08' == $payment_deadline) echo 'selected="selected"';?>>08</option>
											<option value="09" <?php if('09' == $payment_deadline) echo 'selected="selected"';?>>09</option>
											<option value="10" <?php if('10' == $payment_deadline) echo 'selected="selected"';?>>10</option>
											<option value="11" <?php if('11' == $payment_deadline) echo 'selected="selected"';?>>11</option>
											<option value="12" <?php if('12' == $payment_deadline) echo 'selected="selected"';?>>12</option>
											<option value="13" <?php if('13' == $payment_deadline) echo 'selected="selected"';?>>13</option>
											<option value="14" <?php if('14' == $payment_deadline) echo 'selected="selected"';?>>14</option>
											<option value="15" <?php if('15' == $payment_deadline) echo 'selected="selected"';?>>15</option>
											<option value="16" <?php if('16' == $payment_deadline) echo 'selected="selected"';?>>16</option>
											<option value="17" <?php if('17' == $payment_deadline) echo 'selected="selected"';?>>17</option>
											<option value="18" <?php if('18' == $payment_deadline) echo 'selected="selected"';?>>18</option>
											<option value="19" <?php if('19' == $payment_deadline) echo 'selected="selected"';?>>19</option>
											<option value="20" <?php if('20' == $payment_deadline) echo 'selected="selected"';?>>20</option>
											<option value="21" <?php if('21' == $payment_deadline) echo 'selected="selected"';?>>21</option>
											<option value="22" <?php if('22' == $payment_deadline) echo 'selected="selected"';?>>22</option>
											<option value="23" <?php if('23' == $payment_deadline) echo 'selected="selected"';?>>23</option>
											<option value="24" <?php if('24' == $payment_deadline) echo 'selected="selected"';?>>24</option>
											<option value="25" <?php if('25' == $payment_deadline) echo 'selected="selected"';?>>25</option>
											<option value="26" <?php if('26' == $payment_deadline) echo 'selected="selected"';?>>26</option>
											<option value="27" <?php if('27' == $payment_deadline) echo 'selected="selected"';?>>27</option>
											<option value="28" <?php if('28' == $payment_deadline) echo 'selected="selected"';?>>28</option>
											<option value="29" <?php if('29' == $payment_deadline) echo 'selected="selected"';?>>29</option>
											<option value="30" <?php if('30' == $payment_deadline) echo 'selected="selected"';?>>30</option>
											<option value="31" <?php if('31' == $payment_deadline) echo 'selected="selected"';?>>31</option>
										</select>
									</td>
								</tr>
							</table>
						</div><!--col-md-6-->
				</div>
					<table class="table table-bordered responsive nnew200" style="max-width: 96%;margin-left: 30px;">
						<colgroup>
							<col class="con1" />
							<col class="con0" />
							<col class="con1" />
							<col class="con0" />
							<col class="con1" />
							<col class="con0" />
							<col class="con1" />
							<col class="con0" />
						</colgroup>
						 <thead class="newThead">
							<tr>	
								<th style="width: 2%;text-align: center;"><input id="check_all2" class="formcontrol" type="checkbox"/></th>
								<th style="width: 10%;text-align: center;">Particulars</th>
								<th style="width: 15%;text-align: center;">Description</th>
								<th style="width: 5%;text-align: center;">Quantity</th>
								<th style="width: 5%;text-align: center;">Unit</th>
								<th style="width: 5%;text-align: center;">Rate</th>
								<th style="width: 5%;text-align: center;">Vat(%)</th>
								<th style="width: 5%;text-align: center;">Start Date</th>
								<th style="width: 5%;text-align: center;">End Date</th>
								<th style="width: 2%;text-align: center;">Days</th>
								<th style="width: 10%;text-align: center;">Total</th>
							</tr>
						 </thead>
						 <tbody> <?php 
							$invdata = array();
							while($rowwin = mysql_fetch_assoc($ques)) {
								$invdata[] = $rowwin;
							}
							foreach($invdata as $key=>$inv) { 
							$totalpriceee += $inv['total_price'];
							?>												
							<tr class='gradeX'>
								<td class="center"><input class="case2" style="text-align: center;" type="checkbox"/></td>
													<input type="hidden" style="width: 92%;" data-type="productCode" value="<?php echo $inv['item_id'];?>" name="itemNo[]" required="" id="itemNo_<?php echo $key;?>" class="changesNo form-control autocomplete_txt" autocomplete="off">
								<td class="center" ><input type="text" style="width: 92%;" data-type="productName" value="<?php echo $inv['item_name'];?>" name="itemName[]" required="" placeholder="Like: BDIX, Youtube" id="itemName_<?php echo $key;?>" class="changesNo form-control autocomplete_txt" autocomplete="off"></td>
								<td class="center" ><input type="text" style="width: 92%;" value="<?php echo $inv['description'];?>" name="itemDes[]" placeholder="" id="itemDes_<?php echo $key;?>" class="changesNo form-control autocomplete_txt" autocomplete="off"></td>
								<td class="center">
									<input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" value="<?php echo $inv['quantity'];?>" name="quantity[]" class="changesNo" id="quantity_<?php echo $key;?>" style="width: 92%;font-weight: bold;" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
								</td>
								<td class="center" >
									<input type="text" data-type="productUnit" class="" value="<?php echo $inv['unit'];?>" name="unit[]" id="unit_<?php echo $key;?>" class="changesNo form-control autocomplete_txt" autocomplete="off" readonly style="width: 92%;font-weight: bold;text-align: center;"/>
								</td>
								<td class="center">
									<input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" value="<?php echo $inv['uniteprice'];?>" name="uniteprice[]" class="changesNo" id="uniteprice_<?php echo $key;?>" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
								</td>
								<td class="center">
									<input type="text" data-type="productVat" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" value="<?php echo $inv['vat'];?>" name="vat[]" class="changesNo" id="vat_<?php echo $key;?>" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
								</td>
								<td class="center">
									<input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" value="<?php echo $inv['start_date'];?>" name="start_date[]" readonly="" class="changesNo form-control datepicker" id="startdate_<?php echo $key;?>" placeholder="" autocomplete="off"/>
								</td>
								<td class="center">
									<input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" value="<?php echo $inv['end_date'];?>" name="end_date[]" readonly="" class="changesNo form-control datepicker" id="enddate_<?php echo $key;?>" placeholder="" autocomplete="off"/>
								</td>
								<td class="center">
									<input type="text" style="width: 80%;font-size: 14px;font-weight: 700;text-align: center;" data-type="daysss" value="<?php $enddate = strtotime($inv['end_date']); $startdate = strtotime($inv['start_date']); $diff = ($enddate - $startdate)/60/60/24; echo $diff+1;?>" required="" name="days[]" id="days_<?php echo $key;?>" class="changesNo form-control autocomplete_txt" placeholder="" readonly="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
								</td>
								<td class="center"><input type="text" style="width: 92%;font-size: 16px;font-weight: 700;text-align: center;" value="<?php echo $inv['total_price'];?>" name="price[]" id="price_<?php echo $key;?>" readonly class="totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<table class="table responsive" style="max-width: 96%;margin-left: 30px;border: 0;">
						<tr>
							<td style="width: 34%;border: 0;">
								<button class="btn-danger delete2" style="font-size: 25px;" type="button"> - </button>
								<button class="btn-success addmorenew" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
							</td>
							<td style="width: 15%;border: 0;text-align: right;vertical-align: middle;font-size: 25px;font-weight: bold;color: #58666e;font-family: 'Noto Serif',serif;">Total:</td>
							<td style="width: 25%;border: 0;padding: 8px 0px 8px 30px;text-align: right;"><input type="text" style="width: 20px;font-weight: bold;font-size: 20px;border-radius: 5px 0 0 6px;border-right: 0;color: #58666e;height: 30px;text-align: center;" readonly value="৳"/><input type="text" style="width: 55%;font-weight: bold;font-size: 25px;border-radius: 0 5px 5px 0px;height: 30px;color: red;padding: 5px 0px 3px 15px;" name="total_price" required="" readonly value="<?php echo $totalpriceee;?>" id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;"/></td>
						</tr>
						<input type="hidden" style="width: 50%;font-weight: bold;font-size: 18px;color: #58666e;border-radius: 0 5px 5px 0px;" required="" readonly id="subTotal" name="subtotal" value="<?php echo $totalpriceee;?>" placeholder="Subtotal" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;"/>
						<input type="hidden" style="width: 50%;font-weight: bold;font-size: 16px;color: #58666e;border-radius: 0 5px 5px 0px;" id="tax" name="discount" placeholder="Discount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
					</table>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn ownbtn11">Reset</button>
					<button class="btn ownbtn2" type="submit" id="submitdisabl">Submit</button>
				</div>
				</form>	
				<?php } ?>				
			</div>
		</div>
	</div>
<?php }
else{
	echo 'You must Generate Bill fast then try again';
}
include('include/footer.php');
?>

<script src="invoice/js/jquery.min.js"></script>
<script src="invoice/js/jquery-ui.min.js"></script>
<script src="invoice/js/auto_ClientsBillAdjust.js"></script>
<script type="text/javascript" src="invoice/js/bootstrap.min.js"></script>
<script type="text/javascript" src="invoice/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: "dd-mm-yyyy",
//      startDate: "1-5-2022",
        startDate: "<?php echo date('01-m-Y', time());?>",
        endDate: "<?php echo date('t-m-Y', time());?>",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });
	
function disableButton() {
        var btn = document.getElementById('submitdisabl');
        btn.disabled = true;
        btn.innerText = 'Posting...'
}
</script>
