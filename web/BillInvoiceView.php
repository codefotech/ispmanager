<?php
$titel = "Invoice Details";
$Billing = 'active';
include('include/hader.php');
$id = $_GET['id'];
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '11' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(130, $access_arry)){
//---------- Permission -----------

ini_alter('date.timezone','Asia/Almaty');
$this_month_yr = date('Y-m', time());

$quesdd = mysql_query("SELECT c_id, DATE_FORMAT(invoice_date, '%D-%M, %Y') AS invoice_date, DATE_FORMAT(due_deadline, '%D-%M, %Y') AS due_deadline, SUM(total_price) AS invoice_total_price FROM billing_invoice WHERE invoice_id = '$id' AND sts = '0' GROUP BY invoice_id");
$rowwdd = mysql_fetch_assoc($quesdd);
$cid = $rowwdd['c_id'];
$invoice_date = $rowwdd['invoice_date'];
$due_deadline = $rowwdd['due_deadline'];
$invoice_total_price = $rowwdd['invoice_total_price'];

$sqlasa = mysql_query("SELECT `invoice_id`, `invoice_date`, `c_id`, `item_id`, `item_name`, `description`, `quantity`, `unit`, `uniteprice`, `vat`, `start_date`, `end_date`, `days`, `total_price`, `due_deadline`, `date_time` FROM billing_invoice WHERE invoice_id = '$id' AND sts = '0'");

?>
<link rel="stylesheet" href="css/reset-fonts-grids.css" type="text/css" />
<link rel="stylesheet" href="css/resume.css" type="text/css" />
	<div class="pageheader">
        <div class="searchbar">
			<form action='BillPaymentView' method='post' style="float: left;margin-left: 5px;"><input type='hidden' name='id' value='<?php echo $cid;?>'/><button class="btn ownbtn2" type="submit"><i class="iconfa-arrow-left"></i> &nbsp; Back</button></form>	
			<form action='fpdf/BillPrintInvoiceClient' method='post' target='_blank' style="float: left;margin-left: 5px;"><input type='hidden' name='invoice_id' value='<?php echo $id;?>'/><button class="btn ownbtn3" type="submit"><i class="iconfa-print"></i> Print</button></form>	
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Invoice Details [<?php echo $id;?>]</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:right">Client ID&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $cid; ?></td>
								
						<th style="text-align:right">Invoice Date &nbsp;:&nbsp; </th>
						<td style="font-weight: bold;">&nbsp; <?php echo $invoice_date; ?></td>
							
						<th style="text-align:right">Invoice Deadline &nbsp;:&nbsp; </th>
						<td style="font-weight: bold;">&nbsp; <?php echo $due_deadline; ?></td>
							
						<th style="text-align:right;font-weight: bold;">Total Amount&nbsp;:&nbsp; </th>
						<td style="font-weight: bold;color: red;"> &nbsp; <?php echo number_format($invoice_total_price,2); ?></td>
					</tr>	
				</table>
			</div>
			<div id="hd">
			<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center" style='width: 20px;'>S/L</th>
							<th class="head0">Item</th>
							<th class="head1">Description</th>
							<th class="head0 right">Quantity</th>
							<th class="head1">Unit</th>
							<th class="head0 right">Unite Price</th>
							<th class="head1 right">Vat (%)</th>
							<th class="head0 center">Start Date</th>
							<th class="head1 center">End Date</th>
							<th class="head0 right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
						$x = 1;	
								while( $row = mysql_fetch_assoc($sqlasa) )
								{
									echo
										"<tr class='gradeX'>
											<td class='center' style='width: 20px;font-weight: bold;'>{$x}</td>
											<td style='font-weight: bold;'>{$row['item_name']}</td>
											<td class=''>{$row['description']}</td>
											<td class='right' style='width: 50px;'>{$row['quantity']}</td>
											<td style='width: 20px;'>{$row['unit']}</td>
											<td class='right'>{$row['uniteprice']}</td>
											<td class='right' style='width: 40px;'>{$row['vat']}</td>
											<td class='center'>{$row['start_date']}</td>
											<td class='center'>{$row['end_date']}</td>
											<td class='right' style='font-weight: bold;'>{$row['total_price']}</td>
										</tr>\n";
								$x++; }
							?>
							<tr class='gradeX'>
								<td colspan="9" class='right' style="font-weight: bold;font-size: 16px;"> TOTAL</td>
								<td class='right' style="font-weight: bold;color: red;font-size: 18px;"><?php echo number_format($invoice_total_price,2); ?></td>
							</tr>
					</tbody>
				</table>
		</div></div>
		<div class="modal-footer">
					<form action='BillPaymentView' method='post' style="float: left;margin-left: 5px;"><input type='hidden' name='id' value='<?php echo $cid;?>'/><button class="btn ownbtn2" type="submit"><i class="iconfa-arrow-left"></i> &nbsp; Back</button></form>	

			<form action='fpdf/BillPrintInvoiceClient' method='post' target='_blank'><input type='hidden' name='invoice_id' value='<?php echo $id;?>'/><button class="btn ownbtn3" type="submit"><i class="iconfa-print"></i> Print</button></form>	
		</div>
	</div>
	
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
