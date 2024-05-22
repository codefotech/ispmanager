<?php
$titel = "Edit Client Invoice";
$Clients = 'active';
include('include/hader.php');
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(101, $access_arry)){
//---------- Permission -----------

$sqlf = ("SELECT c_name, com_id, invoice_date, due_deadline, total_price, nttn, link_id FROM clients WHERE c_id ='$c_id' ");
$queryf = mysql_query($sqlf);
$row = mysql_fetch_assoc($queryf);
		$c_name= $row['c_name'];
		$com_id= $row['com_id'];
		$invoice_date= $row['invoice_date'];
		$due_deadline= $row['due_deadline'];
		$totalprice= $row['total_price'];
		$nttn= $row['nttn'];
		$link_id= $row['link_id'];

$queryinv2 = mysql_query("SELECT id, item_id, item_name, description, quantity, unit, uniteprice, vat, days, total_price FROM monthly_invoice WHERE c_id = '$c_id' AND sts = '0'");
$invcount = mysql_num_rows($queryinv2);

$query2 = mysql_query("SELECT id, vlan_id, vlan_name FROM vlan WHERE c_id = '$c_id' AND sts = '0'");
$vlancount = mysql_num_rows($query2);

$query2ip = mysql_query("SELECT id, ip_address FROM ip_address WHERE c_id = '$c_id' AND sts = '0'");
$ipcount = mysql_num_rows($query2ip);
?>
	<div class="pageheader">
        <div class="searchbar">
			<form action='ClientEditInvoice' method='post' data-placement='top' data-rel='tooltip' title='Edit Monthy Invoice & Transmission' style="float: left;padding-right: 3px;"><input type='hidden' name='c_id' value='<?php echo $c_id;?>'/><button class='btn ownbtn2'><i class="iconfa-arrow-left"></i>  Edit Other Info</form>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Edit Monthy Invoice & Transmission</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
			<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 45px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">Edit Monthy Invoice & Transmission for [<?php echo $c_id;?>]</div>
					<form id="form" class="stdform" method="post" action="ClientEditMonthlyInvoiceQuery" enctype="multipart/form-data">
						<input type="hidden" name="c_id" value="<?php echo $c_id;?>" />
						<input type="hidden" name="signup_id" value="<?php echo $signup_id;?>" />
						<input type="hidden" name="breseller" value="2" />
						<input type="hidden" name="u_type" value="client" />
						<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date('Y-m-d', time());?>" />
						<input type="hidden" name="entry_time" value="<?php echo date('H:i:s', time());?>" />
						<div class="modal-body" style="overflow: hidden;">
							<div class="span12" style="width: 100%;margin-left: -21px;">
									<div style="float: left;width: 50%;">
									<p>
										<label style="width: 130px;">NTTN Info</label>
										<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="nttn" value = "<?php echo $nttn;?>" placeholder="" id="" class="input-xxlarge" /></span>
									</p>
									<p>
										<label style="width: 130px;">VLAN</label>
										<span class="field" style="margin-left: 0px;">
											<table class="table table-bordered responsive nnew" style="max-width: 50%">
												<colgroup>
													<col class="con1" />
													<col class="con0" />
													<col class="con1" />	
													<col class="con0" />
												</colgroup>
											 <tbody>
												
												<?php 
												if($vlancount > '0'){
												$vlandata = array();
												while($rowwww = mysql_fetch_assoc($query2)) {
													$vlandata[] = $rowwww;
												}
												foreach($vlandata as $key=>$val) { ?>
												<tr class='gradeX'>
													<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input type="checkbox" class="case"/></td>
													<td class="center" style="border-top: 1px solid #dddddd;width: 30%;"><input type="text" style="width: 92%;" value="<?php echo $val['vlan_id'];?>" name="vlanId[]" placeholder="VLAN ID" id="vlanId_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
													<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" value="<?php echo $val['vlan_name'];?>" name="vlanName[]" placeholder="VLAN Name" id="vlanName_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
												</tr>
												<?php }} else{ ?>
												<tr class='gradeX'>
													<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input id="check_all" class="" type="checkbox"/></td>
													<td class="center" style="border-top: 1px solid #dddddd;width: 30%;"><input type="text" style="width: 92%;" name="vlanId[]" placeholder="VLAN ID" id="vlanId_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
													<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="vlanName[]" placeholder="VLAN Name" id="vlanName_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
												</tr>
												<?php } ?>
											</tbody>
											</table>
										</span>
									</p>
									<p>
										<label style="width: 130px;"></label>
										<span class="field" style="margin-left: 0px;">
											<button class="btn-danger delete" style="font-size: 25px;" type="button"> - </button>
											<button class="btn-success addmore" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
										</span>
									</p>
									<p>
									<label style="width: 130px;"></label>
									<table class="table" style="width: max-content;">
										<tr>
											<td class="" style="font-weight: bold;border-bottom: 1px solid #ddd;text-align: right;">Invoice<br/>Date</td>
											<td class="" style="border-right: 2px solid #ddd;width: 90px;border-bottom: 1px solid #ddd;">
												<select class="chzn-select" name="invoice_date" style="width:70%;" />
													<option value="01" <?php if ($invoice_date == '01') echo 'selected="selected"';?>>01</option>
													<option value="02" <?php if ($invoice_date == '02') echo 'selected="selected"';?>>02</option>
													<option value="03" <?php if ($invoice_date == '03') echo 'selected="selected"';?>>03</option>
													<option value="04" <?php if ($invoice_date == '04') echo 'selected="selected"';?>>04</option>
													<option value="05" <?php if ($invoice_date == '05') echo 'selected="selected"';?>>05</option>
													<option value="06" <?php if ($invoice_date == '06') echo 'selected="selected"';?>>06</option>
													<option value="07" <?php if ($invoice_date == '07') echo 'selected="selected"';?>>07</option>
													<option value="08" <?php if ($invoice_date == '08') echo 'selected="selected"';?>>08</option>
													<option value="09" <?php if ($invoice_date == '09') echo 'selected="selected"';?>>09</option>
													<option value="10" <?php if ($invoice_date == '10') echo 'selected="selected"';?>>10</option>
													<option value="11" <?php if ($invoice_date == '11') echo 'selected="selected"';?>>11</option>
													<option value="12" <?php if ($invoice_date == '12') echo 'selected="selected"';?>>12</option>
													<option value="13" <?php if ($invoice_date == '13') echo 'selected="selected"';?>>13</option>
													<option value="14" <?php if ($invoice_date == '14') echo 'selected="selected"';?>>14</option>
													<option value="15" <?php if ($invoice_date == '15') echo 'selected="selected"';?>>15</option>
													<option value="16" <?php if ($invoice_date == '16') echo 'selected="selected"';?>>16</option>
													<option value="17" <?php if ($invoice_date == '17') echo 'selected="selected"';?>>17</option>
													<option value="18" <?php if ($invoice_date == '18') echo 'selected="selected"';?>>18</option>
													<option value="19" <?php if ($invoice_date == '19') echo 'selected="selected"';?>>19</option>
													<option value="20" <?php if ($invoice_date == '20') echo 'selected="selected"';?>>20</option>
													<option value="21" <?php if ($invoice_date == '21') echo 'selected="selected"';?>>21</option>
													<option value="22" <?php if ($invoice_date == '22') echo 'selected="selected"';?>>22</option>
													<option value="23" <?php if ($invoice_date == '23') echo 'selected="selected"';?>>23</option>
													<option value="24" <?php if ($invoice_date == '24') echo 'selected="selected"';?>>24</option>
													<option value="25" <?php if ($invoice_date == '25') echo 'selected="selected"';?>>25</option>
													<option value="26" <?php if ($invoice_date == '26') echo 'selected="selected"';?>>26</option>
													<option value="27" <?php if ($invoice_date == '27') echo 'selected="selected"';?>>27</option>
													<option value="28" <?php if ($invoice_date == '28') echo 'selected="selected"';?>>28</option>
													<option value="29" <?php if ($invoice_date == '29') echo 'selected="selected"';?>>29</option>
													<option value="30" <?php if ($invoice_date == '30') echo 'selected="selected"';?>>30</option>
													<option value="31" <?php if ($invoice_date == '31') echo 'selected="selected"';?>>31</option>
												</select>
											</td>
											<td class="" style="width: 90px;border-bottom: 1px solid #ddd;text-align: right;">
												<select class="chzn-select" name="due_deadline" style="width:70%;" />
													<option value="01" <?php if ($due_deadline == '01') echo 'selected="selected"';?>>01</option>
													<option value="02" <?php if ($due_deadline == '02') echo 'selected="selected"';?>>02</option>
													<option value="03" <?php if ($due_deadline == '03') echo 'selected="selected"';?>>03</option>
													<option value="04" <?php if ($due_deadline == '04') echo 'selected="selected"';?>>04</option>
													<option value="05" <?php if ($due_deadline == '05') echo 'selected="selected"';?>>05</option>
													<option value="06" <?php if ($due_deadline == '06') echo 'selected="selected"';?>>06</option>
													<option value="07" <?php if ($due_deadline == '07') echo 'selected="selected"';?>>07</option>
													<option value="08" <?php if ($due_deadline == '08') echo 'selected="selected"';?>>08</option>
													<option value="09" <?php if ($due_deadline == '09') echo 'selected="selected"';?>>09</option>
													<option value="10" <?php if ($due_deadline == '10') echo 'selected="selected"';?>>10</option>
													<option value="11" <?php if ($due_deadline == '11') echo 'selected="selected"';?>>11</option>
													<option value="12" <?php if ($due_deadline == '12') echo 'selected="selected"';?>>12</option>
													<option value="13" <?php if ($due_deadline == '13') echo 'selected="selected"';?>>13</option>
													<option value="14" <?php if ($due_deadline == '14') echo 'selected="selected"';?>>14</option>
													<option value="15" <?php if ($due_deadline == '15') echo 'selected="selected"';?>>15</option>
													<option value="16" <?php if ($due_deadline == '16') echo 'selected="selected"';?>>16</option>
													<option value="17" <?php if ($due_deadline == '17') echo 'selected="selected"';?>>17</option>
													<option value="18" <?php if ($due_deadline == '18') echo 'selected="selected"';?>>18</option>
													<option value="19" <?php if ($due_deadline == '19') echo 'selected="selected"';?>>19</option>
													<option value="20" <?php if ($due_deadline == '20') echo 'selected="selected"';?>>20</option>
													<option value="21" <?php if ($due_deadline == '21') echo 'selected="selected"';?>>21</option>
													<option value="22" <?php if ($due_deadline == '22') echo 'selected="selected"';?>>22</option>
													<option value="23" <?php if ($due_deadline == '23') echo 'selected="selected"';?>>23</option>
													<option value="24" <?php if ($due_deadline == '24') echo 'selected="selected"';?>>24</option>
													<option value="25" <?php if ($due_deadline == '25') echo 'selected="selected"';?>>25</option>
													<option value="26" <?php if ($due_deadline == '26') echo 'selected="selected"';?>>26</option>
													<option value="27" <?php if ($due_deadline == '27') echo 'selected="selected"';?>>27</option>
													<option value="28" <?php if ($due_deadline == '28') echo 'selected="selected"';?>>28</option>
													<option value="29" <?php if ($due_deadline == '29') echo 'selected="selected"';?>>29</option>
													<option value="30" <?php if ($due_deadline == '30') echo 'selected="selected"';?>>30</option>
													<option value="31" <?php if ($due_deadline == '31') echo 'selected="selected"';?>>31</option>
												</select>
											</td>
											<td class="" style="font-weight: bold;text-align: left;border-bottom: 1px solid #ddd;">Due<br/>Deadline</td>
										</tr>
									</table>
									</p>
									</div>
									<div style="margin-left: 48%;">
									<p>
										<label style="width: 130px;">Link Id</label>
										<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="link_id" value = "<?php echo $link_id;?>" placeholder="" id="" class="input-xlarge" /></span>
									</p>
									<p>
										<label style="width: 130px;">IP Address</label>
										<span class="field" style="margin-left: 0px;">
											<table class="table table-bordered responsive nnew1" style="max-width: 50%">
												<colgroup>
													<col class="con1" />
													<col class="con0" />
												</colgroup>
											 <tbody>
											 <?php 
												if($ipcount > '0'){
												$ipdata = array();
												while($rowip = mysql_fetch_assoc($query2ip)) {
													$ipdata[] = $rowip;
												}
												foreach($ipdata as $key=>$valip) { ?>
												<tr class='gradeX'>
													<td class="center" style="width: 1%;border-top: 1px solid #dddddd;"><input type="checkbox" class="case5"/></td>
													<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" value="<?php echo $valip['ip_address'];?>" name="ipaddress[]" placeholder="IP Address 1" id="ipaddress_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
												</tr>
												<?php }} else{ ?>
												<tr class='gradeX'>
													<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input id="check_all1" class="" type="checkbox"/></td>
													<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="ipaddress[]" placeholder="IP Address 1" id="ipaddress_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
												</tr>
												<?php } ?>
											</tbody>
											</table>
										</span>
									</p>
									<p>
										<label style="width: 130px;"></label>
										<span class="field" style="margin-left: 0px;">
											<button class="btn-danger deletee1" style="font-size: 25px;" type="button"> - </button>
											<button class="btn-success addmore1" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
										</span>
									</p>
									
									</div>
										<table class="table table-bordered responsive nnew20" style="max-width: 96%;margin-left: 30px;">
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
													<th style="width: 10%;text-align: center;">Total</th>
												</tr>
											 </thead>
											 <tbody> <?php 
												$invdata = array();
												while($rowwin = mysql_fetch_assoc($queryinv2)) {
													$invdata[] = $rowwin;
												}
												foreach($invdata as $key=>$inv) { 
												$totalpriceee += $inv['total_price'];
												?>												
												<tr class='gradeX'>
													<td class="center"><input class="case2" style="text-align: center;" type="checkbox"/></td>
																		<input type="hidden" style="width: 92%;" data-type="productCode" value="<?php echo $inv['item_id'];?>" name="itemNo[]" required="" id="itemNo_<?php echo $key;?>" class="changesNoform-control autocomplete_txt" autocomplete="off">
													<td class="center" ><input type="text" style="width: 92%;" data-type="productName" value="<?php echo $inv['item_name'];?>" name="itemName[]" required="" placeholder="Like: BDIX, Youtube" id="itemName_<?php echo $key;?>" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
													<td class="center" ><input type="text" style="width: 92%;" value="<?php echo $inv['description'];?>" name="itemDes[]" placeholder="" id="itemDes_<?php echo $key;?>" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
													<td class="center">
														<input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" value="<?php echo $inv['quantity'];?>" name="quantity[]" class="changesNo" id="quantity_<?php echo $key;?>" style="width: 92%;font-weight: bold;" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
													</td>
													<td class="center" >
														<input type="text" data-type="productUnit" class="" value="<?php echo $inv['unit'];?>" name="unit[]" id="unit_<?php echo $key;?>" class="changesNoform-control autocomplete_txt" autocomplete="off" readonly style="width: 92%;font-weight: bold;text-align: center;"/>
													</td>
													<td class="center">
														<input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" value="<?php echo $inv['uniteprice'];?>" name="uniteprice[]" class="changesNo" id="uniteprice_<?php echo $key;?>" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
													</td>
													<td class="center">
														<input type="text" data-type="productVat" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" value="<?php echo $inv['vat'];?>" name="vat[]" class="changesNo" id="vat_<?php echo $key;?>" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
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
													<button class="btn-success addmoreedit" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
												</td>
												<td style="width: 15%;border: 0;text-align: right;vertical-align: middle;font-size: 25px;font-weight: bold;color: #58666e;font-family: 'Noto Serif',serif;">Total:</td>
												<td style="width: 25%;border: 0;padding: 8px 0px 8px 30px;text-align: right;"><input type="text" style="width: 20px;font-weight: bold;font-size: 20px;border-radius: 5px 0 0 6px;border-right: 0;color: #58666e;height: 30px;text-align: center;" readonly value="৳"/><input type="text" style="width: 55%;font-weight: bold;font-size: 25px;border-radius: 0 5px 5px 0px;height: 30px;color: red;padding: 5px 0px 3px 15px;" name="total_price" required="" readonly value="<?php echo $totalpriceee;?>" id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;"/></td>
											</tr>
											<input type="hidden" style="width: 50%;font-weight: bold;font-size: 18px;color: #58666e;border-radius: 0 5px 5px 0px;" required="" readonly id="subTotal" name="subtotal" value="<?php echo $totalpriceee;?>" placeholder="Subtotal" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;"/>
											<input type="hidden" style="width: 50%;font-weight: bold;font-size: 16px;color: #58666e;border-radius: 0 5px 5px 0px;" id="tax" name="discount" placeholder="Discount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
										</table>
							</div>
						</div>
						<?php if($totmk != '0'){?>
							<div class="modal-footer">
								<button type="reset" class="btn ownbtn11">Reset</button>
								<button class="btn ownbtn2" type="submit">Submit</button>
							</div>
						<?php } ?>
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
<script src="invoice/js/jquery.min.js"></script>
<script src="invoice/js/jquery-ui.min.js"></script>
<script src="invoice/js/auto_ClientEditMonthlyInvoice.js"></script>